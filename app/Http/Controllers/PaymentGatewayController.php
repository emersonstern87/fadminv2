<?php

namespace App\Http\Controllers;

use URL;
use Illuminate\Http\Request;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use Stripe;
use Session;
use Redirect;
use Illuminate\Support\Facades\Input;
use PayPal\Api\PaymentExecution;
use App\Http\Controllers\GeneralLedgerController;
use Auth;
use Cache;
use App\Model\Transaction as Trans;
use App\Model\CustomerTransaction;
use App\Model\SaleOrder;
use App\Model\PaymentMethod;
use App\Model\Preference;
use App\Model\Currency;
use DB;

class PaymentGatewayController extends Controller
{
    public function __construct()
    {
		$options = PaymentMethod::getAll()->where('id', 1)->first()->toArray();

        $configs = $this->initializePaypal($options);
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
            $configs['client_id'],
            $configs['secret'])
        );
        $this->_api_context->setConfig($configs['settings']);
	}

	public function payWithpaypal(Request $request)
    {
    	$companyName = Preference::getAll()->where('category', 'company')->where('field', 'company_name')->first()->value;
    	$data = $request->all();
		$payer = new Payer();
		        $payer->setPaymentMethod('paypal');

        $allowedCurrencies = ['AUD', 'BRL', 'CAD', 'CZK', 'DKK', 'EUR', 'HKD', 'HUF', 'ILS', 'INR', 'JPY', 'MYR', 'MXN', 'NOK', 'NZD', 'PHP', 'PLN', 'GBP', 'SGD', 'SEK', 'CHF', 'TWD', 'THB', 'USD', 'RUB'];

        // Check if provided currency is valid.
        if (!in_array($request->curencyName, $allowedCurrencies, true)) {
            \Session::flash('fail', 'This currency is not supported by PayPal.');
            return redirect('customer-panel/view-detail-invoice/'.$request->invoiceId);
        }

        Cache::put('gb-paypal-payment-info-'. $request->invoiceId, $data, 3600);

		$amount = new Amount();
		        $amount->setCurrency($request->curencyName)
		            ->setTotal($request->payPalAmount);
		$transaction = new Transaction();
		        $transaction->setAmount($amount)
		            ->setDescription($companyName);
		$redirect_urls = new RedirectUrls();
		        $redirect_urls->setReturnUrl(URL::to('status/'.$request->invoiceId)) /** Specify return URL **/
		            ->setCancelUrl(URL::to('status/'.$request->invoiceId));
		$payment = new Payment();
		        $payment->setIntent('Sale')
		            ->setPayer($payer)
		            ->setRedirectUrls($redirect_urls)
		            ->setTransactions(array($transaction));
		try {
			$payment->create($this->_api_context);
		} catch (\PayPal\Exception\PPConnectionException $ex) {
			if (\Config::get('app.debug')) {
			\Session::flash('fail', __('Connection timeout'));
			                return Redirect::route('paywithpaypal');
			} else {
			\Session::flash('fail', __('Some error occur, sorry for inconvenient'));
			                return Redirect::route('paywithpaypal');
			}
		}
		foreach ($payment->getLinks() as $link) {
			if ($link->getRel() == 'approval_url') {
				$redirect_url = $link->getHref();
		                break;
			}
		}
		/** add payment ID to session **/
		\Session::flash('paypal_payment_id', $payment->getId());
		if (isset($redirect_url)) {
		/** redirect to paypal **/
		    return Redirect::away($redirect_url);
		}
		\Session::flash('fail', __('Unknown error occurred'));
		    return Redirect::route('paywithpaypal');
	}


	public function getPaymentStatus($id)
    {
      /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');
        /** clear the session payment ID **/
        Session::forget('paypal_payment_id');
        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
            \Session::flash('fail', 'Payment failed');
            return redirect()->intended('customer-panel/view-detail-invoice/'.$id);
        }
        $payment = Payment::get($payment_id, $this->_api_context);
            $execution = new PaymentExecution();
            $execution->setPayerId(Input::get('PayerID'));

        $data = Cache::get('gb-paypal-payment-info-'. $id);

        /**Execute the payment **/
        $result = $payment->execute($execution, $this->_api_context);
        if ($result->getState() == 'approved') {
        	try {
        		DB::beginTransaction();
        		$reference_id = (new GeneralLedgerController)->createReference($data['payPalReference'], 'INVOICE_PAYMENT', $data['invoiceId']); 
        		if ($reference_id) {
                    $bankTrans                              = new Trans;
			        $bankTrans->currency_id                 = $data['curencyId'];
			        $bankTrans->amount                      = $data['payPalAmount'];
			        $bankTrans->transaction_type            = 'cash-in-by-sale';
			        $bankTrans->transaction_date            = date("Y-m-d") ;
			        $bankTrans->transaction_reference_id    = $reference_id;
			        $bankTrans->transaction_method          = 'INVOICE_PAYMENT';
			        $bankTrans->payment_method_id           = 1; 
			        $bankTrans->save();
                    

                    $customer_transaction                           = new CustomerTransaction;
			        $customer_transaction->payment_method_id        = 1;
			        $customer_transaction->customer_id              = $data['customerId'];
			        $customer_transaction->sale_order_id            = $id;
			        $customer_transaction->transaction_reference_id = $reference_id;
			        $customer_transaction->currency_id              = $data['curencyId'];
			        $customer_transaction->transaction_date         = date("Y-m-d");
			        $customer_transaction->amount                   = $data['payPalAmount'];
			        $customer_transaction->exchange_rate            = 1;
			        $customer_transaction->save();

			        // update paid amount
                    $old_paid_amount = SaleOrder::find($id);
                    $sum = ( (float) $old_paid_amount->paid + $data['payPalAmount']);
                    $old_paid_amount->paid = $sum;
                    $old_paid_amount->save();

                    DB::commit();
            		\Session::flash('success', __('Payment success!'));
            		return redirect()->intended('customer-panel/view-detail-invoice/'.$id);
			    }
        	} catch (\Exception $e) {
        		DB::rollBack();
        		\Session::flash('fail', __('Payment failed'));
        		return redirect()->intended('customer-panel/view-detail-invoice/'.$id);
        	}
            Cache::forget('gb-paypal-payment-info-'. $id);
        }
        \Session::flash('fail', __('Payment failed'));
        return redirect()->intended('customer-panel/view-detail-invoice/'.$id);
	}
  
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {
    	$secret = PaymentMethod::getAll()->where('id', 3)->first()->consumer_secret;
    	$companyName = Preference::getAll()->where('category', 'company')->where('field', 'company_name')->first()->value;
        Stripe\Stripe::setApiKey($secret);

        $allowedCurrencies = ['USD', 'AED', 'AFN', 'ALL', 'AMD', 'ANG', 'AOA', 'ARS', 'AUD', 'AWG', 'AZN', 'BAM', 'BBD', 'BDT', 'BGN', 'BIF', 'BMD', 'BND', 'BOB', 'BRL', 'BSD', 'BWP', 'BZD', 'CAD', 'CDF', 'CHF', 'CLP', 'CNY', 'COP', 'CRC', 'CVE', 'CZK', 'DJF', 'DKK', 'DOP', 'DZD', 'EGP', 'ETB', 'EUR', 'FJD', 'FKP', 'GBP', 'GEL', 'GIP', 'GMD', 'GNF', 'GTQ', 'GYD', 'HKD', 'HNL', 'HRK', 'HTG', 'HUF', 'IDR', 'ILS', 'INR', 'ISK', 'JMD', 'JPY', 'KES', 'KGS', 'KHR', 'KMF', 'KRW', 'KYD', 'KZT', 'LAK', 'LBP','LKR', 'LRD', 'LSL', 'MAD', 'MDL', 'MGA', 'MKD', 'MMK', 'MNT', 'MOP', 'MRO', 'MUR', 'MVR', 'MWK', 'MXN', 'MYR', 'MZN', 'NAD', 'NGN', 'NIO', 'NOK', 'NPR', 'NZD', 'PAB', 'PEN', 'PGK', 'PHP', 'PKR', 'PLN', 'PYG', 'QAR', 'RON', 'RSD', 'RUB', 'RWF', 'SAR', 'SBD', 'SCR', 'SEK', 'SGD', 'SHP', 'SLL', 'SOS', 'SRD', 'STD', 'SZL', 'THB', 'TJS', 'TOP', 'TRY', 'TTD', 'TWD', 'TZS', 'UAH', 'UGX', 'UYU', 'UZS', 'VND', 'VUV', 'WST', 'XAF', 'XCD', 'XOF', 'XPF', 'YER', 'ZAR', 'ZMW'];

     	// Check if provided currency is valid.
        if (!in_array($request->stripeCurencyName, $allowedCurrencies, true)) {
            \Session::flash('fail', 'This currency is not supported by Stripe.');
            return redirect('customer-panel/view-detail-invoice/'.$request->stripeInvoiceId);
        } 

        try {
		    $charge = Stripe\Charge::create ([
		                "amount" => round(round($request->stripeAmount, 2) * 100, 2),
		                "currency" => $request->stripeCurencyName,
		                "source" => $request->stripeToken,
		                "description" => $companyName 
        	]);

        	if ($charge->status == "succeeded") {
        		try {
	        		DB::beginTransaction();
	        		$reference_id = (new GeneralLedgerController)->createReference($request->stripeReference, 'INVOICE_PAYMENT', $request->stripeInvoiceId); 
	        		if ($reference_id) {
	                    $bankTrans                              = new Trans;
				        $bankTrans->currency_id                 = $request->stripeCurencyId;
				        $bankTrans->amount                      = $request->stripeAmount;
				        $bankTrans->transaction_type            = 'cash-in-by-sale';
				        $bankTrans->transaction_date            = date("Y-m-d") ;
				        $bankTrans->transaction_reference_id    = $reference_id;
				        $bankTrans->transaction_method          = 'INVOICE_PAYMENT';
				        $bankTrans->payment_method_id           = 3; 
				        $bankTrans->save();
	                    

	                    $customer_transaction                           = new CustomerTransaction;
				        $customer_transaction->payment_method_id        = 3;
				        $customer_transaction->customer_id              = $request->stripeCustomerId;
				        $customer_transaction->sale_order_id            = $request->stripeInvoiceId;
				        $customer_transaction->transaction_reference_id = $reference_id;
				        $customer_transaction->currency_id              = $request->stripeCurencyId;
				        $customer_transaction->transaction_date         = date("Y-m-d");
				        $customer_transaction->amount                   = $request->stripeAmount;
				        $customer_transaction->exchange_rate            = 1;
				        $customer_transaction->save();
				        // update paid amount
	                    $old_paid_amount = SaleOrder::find($request->stripeInvoiceId);
	                    $sum = ( (float) $old_paid_amount->paid + $request->stripeAmount);
	                    $old_paid_amount->paid = $sum;
	                    $old_paid_amount->save();

	                    DB::commit();
	            		\Session::flash('success', __('Payment success!'));
	            		return back();
				    }
	        	} catch (\Exception $e) {
	        		DB::rollBack();
	        		\Session::flash('fail', __('Payment failed'));
	        		return back();
	        	}
        	}
		} catch(Stripe\Exception\InvalidRequestException $e) {
		  	$error = $e->getMessage();
		  	Session::flash('fail', $error);
		    return back();
		}
	}

	protected function initializePaypal($options = []) 
	{
		$configs = [ 
		    'client_id' => $options['client_id'],
		    'secret' => $options['consumer_secret'],
		    'settings' => array(
		        'mode' => $options['mode'],
		        'http.ConnectionTimeOut' => 30,
		        'log.LogEnabled' => true,
		        'log.FileName' => storage_path() . '/logs/paypal.log',
		        'log.LogLevel' => 'ERROR'
		    ),
		];

		return $configs;
	}

	public function bankPayment(Request $request)
    {
    	$exchangeRate = (new Currency)->getExchangeRate($request->toCurrency, $request->invoice_currency_id);
    	try {
    		DB::beginTransaction();
    		$reference_id = (new GeneralLedgerController)->createReference($request->order_reference, 'INVOICE_PAYMENT', $request->order_no); 
    		if ($reference_id) {                
                $customer_transaction                           = new CustomerTransaction;
		        $customer_transaction->payment_method_id        = 2;
		        $customer_transaction->customer_id              = $request->customer_id;
		        $customer_transaction->sale_order_id            = $request->order_no;
		        $customer_transaction->transaction_reference_id = $reference_id;
		        $customer_transaction->currency_id              = $request->invoice_currency_id;
		        $customer_transaction->transaction_date         = DbDateFormat($request->payment_date);
		        $customer_transaction->amount                   = validateNumbers($request->amount);
		        $customer_transaction->exchange_rate            = $exchangeRate;

		        $bankAccount = PaymentMethod::getAll()->where('name', 'Bank')->first();
		        if ($bankAccount->approve == "manual") {
		        	$customer_transaction->account_id = $bankAccount->client_id;
		        	$customer_transaction->status = "Pending";
		        	$customer_transaction->save();
		        } else {
		        	$customer_transaction->save();
		        	$bankTrans                              = new Trans;
			        $bankTrans->currency_id                 = $request->toCurrency;
			        $bankTrans->amount                      = validateNumbers($request->amount) * $exchangeRate;
					$bankTrans->transaction_type            = 'cash-in-by-sale';
			        $bankTrans->account_id           	    = $request->account_id;
			        $bankTrans->transaction_date            = $request->payment_date;
			        $bankTrans->transaction_reference_id    = $reference_id;
			        $bankTrans->transaction_method          = 'INVOICE_PAYMENT';
			        $bankTrans->payment_method_id           = 2; 
			        $bankTrans->save();
			        // update paid amount
	                $old_paid_amount = SaleOrder::find($request->order_no);
	                $sum = ( (float) $old_paid_amount->paid + validateNumbers($request->amount));
	                $old_paid_amount->paid = $sum;
	                $old_paid_amount->save();
		        }

                DB::commit();
        		\Session::flash('success', __('Payment success!'));
        		return back();
		    }
    	} catch (\Exception $e) {
    		DB::rollBack();
    		\Session::flash('fail', __('Payment failed'));
    		return back();
    	}
	}

}
