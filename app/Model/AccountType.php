<?php

namespace App\Model;
use DB;
use Illuminate\Database\Eloquent\Model;

class AccountType extends Model
{
    public $timestamps = false;

    //Relation Start
    public function accounts()
    {
        return $this->hasMany("App\Model\Account", 'account_type_id');
    }
    //Relation End

}
