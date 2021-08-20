<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class PurchasePrice extends Model
{
    public $timestamps  = false;
    protected $fillable = ['item_id', 'price'];

    public function item()
    {
      return $this->belongsTo("App\Model\Item", 'item_id');
    }
}
