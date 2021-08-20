<?php

namespace App\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Cache;
use Auth;


class Customer extends Authenticatable
{
	protected $table = "customers";
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name','last_name','email','is_activated','password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function customerBranch()
    {
        return $this->hasOne("App\Model\CustomerBranch", 'customer_id');
    }

    public function currency()
    {
        return $this->belongsTo('App\Model\Currency','currency_id');
    }

    public function projects()
    {
        return $this->hasMany('App\Model\Project', 'customer_id');
    }

    public function tickets()
    {
        return $this->hasMany('App\Model\Ticket', 'customer_id');
    }

    public function activity()
    {
        return $this->hasOne('App\Model\Activity', 'customer_id');
    }

    public static function getTimezone()
    {
        $loggedCustomer = Auth::guard('customer')->user()->id;
        $data = Cache::get('gb-dflt_timezone_customer'.$loggedCustomer);
        if (empty($data)) {
            $data = parent::find($loggedCustomer)->timezone;
            Cache::put('gb-dflt_timezone_customer'.$loggedCustomer, $data, 30 * 86400);
        }
        return $data;
    }
}
