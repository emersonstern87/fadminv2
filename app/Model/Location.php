<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Cache;

class Location extends Model
{
    public function saleOrders()
    {
        return $this->hasMany('App\Model\SaleOrder', 'location_id');
    }
    
    public function purchaseOrders()
    {
    	return $this->hasMany('App\Model\PurchaseOrder', 'location_id');
    }

    public function stockTransferDestinatin()
    {
        return $this->hasMany('App\Model\StockTransfer', 'destination_location_id');
    }

    public function stockTransferSource()
    {
        return $this->hasMany('App\Model\StockTransfer', 'source_location_id');
    }

    public function stockMoves()
    {
        return $this->hasMany('App\Model\StockMove');
    }

    public static function getAll()
    {
        $data = Cache::get('gb-locations');
        if (empty($data)) {
            $data = parent::all();
            Cache::put('gb-locations', $data, 30 * 86400);
        }
        return $data;
    }

    public static function getLocationName($id)
    {
        $location = Location::where('id', $id)->first();
        return $location->name;
    }
}
