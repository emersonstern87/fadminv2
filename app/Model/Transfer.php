<?php

namespace App\Model;
use DB;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    public $timestamps = false;

    public function fromBank()
    {
       return $this->belongsTo("App\Model\Account", 'from_account_id');
    }
    public function toBank()
    {
       return $this->belongsTo("App\Model\Account", 'to_account_id');
    }

    public function currency()
    {
    	 return $this->belongsTo("App\Model\Currency", 'to_currency_id');
    }

    public function transactionReference()
    {
         return $this->belongsTo("App\Model\TransactionReference");
    }
}
