<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class StockAdjustmentDetail extends Model
{
	public $timestamps = false;

	public function stockAdjustment()
	{
		return $this->belongsTo("App\Model\StockAdjustment");
	}

	public function item()
	{
		return $this->belongsTo("App\Model\Item");
	}
}