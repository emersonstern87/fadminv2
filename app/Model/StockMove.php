<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StockMove extends Model
{
	public $timestamps = false;
    
    public function item()
    {
    	return $this->belongsTo("App\Model\Item", 'item_id');
  	}

  	public function location()
  	{
  		return $this->belongsTo("App\Model\Location");
  	}

  	public function saleOrder()
  	{
  		return $this->belongsTo("App\Model\SaleOrder", 'transaction_type_id');
  	}

	public function getItemQtyByLocationName($location_id, $item_id)
	{
		$qty = $this->where(['location_id' => $location_id, 'item_id' => $item_id])->sum('quantity');
	    if (empty($qty)) {
	        $qty = 0;
	    }
	    return $qty;
	}

}
