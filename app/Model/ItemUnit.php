<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class ItemUnit extends Model
{
    public function stockCategory()
    {
        return $this->hasMany('App\Model\StockCategory', 'item_unit_id');
    }
    
    public function items()
    {
        return $this->hasMany('App\Model\Item', 'item_unit_id');
    }
}
