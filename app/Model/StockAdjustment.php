<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class StockAdjustment extends Model
{
	public $timestamps = false;

	public function location()
	{
		return $this->belongsTo("App\Model\Location");
	}

	public function stockAdjustmentDetails()
	{
		return $this->hasMany("App\Model\StockAdjustmentDetail");
	}
}