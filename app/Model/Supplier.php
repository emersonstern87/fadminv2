<?php

namespace App\Model;
use DB;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    public $timestamps = false;

    public function currency()
    {
        return $this->belongsTo("App\Model\Currency",'currency_id');
    }
    public function country()
    {
    	return $this->belongsTo("App\Model\Country", 'country_id');
    }
    public function purchaseOrders()
    {
        return $this->hasMany('App\Model\PurchaseOrder', 'supplier_id');
    }
}
