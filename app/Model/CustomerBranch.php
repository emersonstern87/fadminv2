<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class CustomerBranch extends Model
{
	public $timestamps = false;

    public function customer()
    {
        return $this->belongsTo("App\Model\Customer", 'customer_id');
    }
    public function billingCountry()
    {
    	return $this->belongsTo("App\Model\Country", 'billing_country_id');
    }
    public function shippingCountry()
    {
        return $this->belongsTo("App\Model\Country", 'shipping_country_id');
    }
    public function saleOrders()
    {
        return $this->hasMany('App\Model\SaleOrder', 'customer_branch_id');
    }
}
