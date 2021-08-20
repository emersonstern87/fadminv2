<?php

namespace App\Http\Controllers;

use App\Http\Controllers\EmailController;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Session;
use Hash;
use Validator;
use Auth;
use Mail;
use App\Model\Customer;
use App\Model\EmailConfiguration;
use App\Model\EmailTemplate;
use App\Model\Preference;
use App\Model\Country;
use PHPMailer\PHPMailer\PHPMailer;

class CustomerRegistrationController extends Controller
{
    protected $guard = 'customer';
    public function __construct(Request $request, EmailController $email)
    {
        $this->email = $email;
    }

    public function create()
    {
        $data['countries']   = Country::getAll()->pluck('name', 'id')->toArray();
        $prefer = Preference::getAll()->pluck('value', 'field')->toArray();
        $data['companyData'] = $prefer['company_name'];
        return view('auth.customer_register', $data);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'email'                 => 'required | email | unique:customers,email',
            'first_name'            => 'required',
            'last_name'             => 'required',
            'password'              => 'required | min:6',
            'password_confirmation' => 'required | same:password',
            'country'            => 'required'
        ]);
        $timeZone = Preference::getAll()->where('category', 'preference')
                                        ->where('field', 'default_timezone')->first()->value;
        $data = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'name'      =>  $request->first_name.' '. $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'timezone' => $timeZone,
            'currency_id' => 1,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $insertId = DB::table('customers')->insertGetId($data);
        if ($insertId) {
            $data2 = [
                'customer_id' => $insertId,
                'name' => $request->first_name.' '.$request->last_name,
                'billing_state' => !empty($request->state) ? $request->state : null,
                'billing_country_id' => $request->country
            ];
            DB::table('customer_branches')->insert($data2);
        }
        
        $customer_active = ['token_link' => str_random(30)];

        DB::table('customer_activations')->insert(['customer_id' => $insertId, 'token' => $customer_active['token_link']]);
                    
        $emailData = EmailTemplate::where(['language_short_name' => 'en', 'template_id' => 16])->first();
        $activeFormat = '<a href="%s">' . __('Click here to active account') . '</a>';
        $active_account = sprintf($activeFormat, url('customer/activation/' . $customer_active['token_link']));

        $email_config = EmailConfiguration::first();

        $prefer = Preference::getAll()->pluck('value', 'field')->toArray();

        $sentData = [
            'email' => $request->email,
            'link' => $active_account,
            'token' => $customer_active['token_link'],
            'from_email' => (!empty($prefer['company_email']) ? $prefer['company_email'] : 'support@example.com'),
            'from_name' => (!empty($prefer['company_name'])?$prefer['company_name']:'support')
        ];

        if ($email_config->protocol=='smtp' && $email_config->status==1) {
            $this->email->setupEmailConfig();   
            Mail::send('auth.emails.actived', ['data' => $sentData], function ($message) use ($sentData) {
                $message->from( $sentData['from_email'], $sentData['from_name']);
                $message->to($sentData['email'])->subject( __('Active Your Account') );
            });
        } else {
            $subject = __("Active Your Account");
            $linkFormat = __('customer/activation/') . '%s';
            $link = sprintf($linkFormat, $sentData['token']);
            $messageFormat = __("Click here to active your account:") . "<a href=%s>%s</a>";
            $message = sprintf($messageFormat, url($link), url($link));
            $this->sendPhpEmail($request->email, $subject, $message, $sentData['from_email'], $sentData['from_name']);
        }
        return redirect('/customer')->with('success', __("We sent you an activation link. Check your email and click on the link to verify."));
    }

    public function sendPhpEmail($to, $subject, $message,$fromEmail,$fromName)
    {
        require 'vendor/autoload.php';
        $mail           = new PHPMailer(true);
        $mail->From     = $fromEmail;
        $mail->FromName = $fromName;
        $mail->AddAddress($to);
        $mail->WordWrap = 50;
        $mail->IsHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;
        $mail->AltBody = strip_tags("Message");
        $mail->Send();
    }

    public function customerActivation($token){
        $check = DB::table('customer_activations')->where('token',$token)->first();
        if (!is_null($check)) {
            $customer = Customer::find($check->customer_id);
            if (!is_null($customer)) {
                if ($customer->is_active == 0 || $customer->is_verified == 0) {
                    $customer->is_active = 1;
                    $customer->is_verified = 1;
                    $customer->save();
                    DB::table('customer_activations')->where('token',$token)->delete();
                    return redirect('/customer')->with('success', __("Success! Your email address has been verified."));
    
                }
            }
        }
        return redirect('/customer')->with('Warning', __("Your token is invalid."));
    }
}