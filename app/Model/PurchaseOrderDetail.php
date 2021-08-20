<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class PurchaseOrderDetail extends Model
{
    public $timestamps = false;

    public function purchaseOrder()
    {
    	return $this->belongsTo('App\Model\PurchaseOrder', 'purchase_order_id');
    }

    public function item()
    {
    	return $this->belongsTo('App\Model\Item', 'item_id');
    }

    public function purchaseTaxes()
    {
    	return $this->hasMany('App\Model\PurchaseTax', 'purchase_order_detail_id');
    }

    public function totalTax()
    {
        return $this->hasOne('App\Model\PurchaseTax')
                ->selectRaw('purchase_order_detail_id,SUM(tax_amount) as total_tax')
                ->groupBy('purchase_order_detail_id');
    }
}
