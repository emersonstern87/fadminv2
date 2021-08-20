<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ReceivedOrderDetail extends Model
{
    public $timestamps = false;
    public function receivedOrder()
    {
    	return $this->belongsTo('App\Model\ReceivedOrder', 'received_order_id');
    }

    public function purchaseOrder()
    {
    	return $this->belongsTo('App\Model\PurchaseOrder', 'purchase_order_id');
    }
}
