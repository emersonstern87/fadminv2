<?php

namespace App\Model;
use DB;
use Illuminate\Database\Eloquent\Model;

class GeneralLedgerTransaction extends Model
{
    public $timestamps = false;

    public function reference()
    {
        return $this->belongsTo("App\Model\Reference", 'reference_id');
    }

    public function incomeExpenseCategory()
    {
        return $this->belongsTo("App\Model\IncomeExpenseCategory", 'gl_account_id');
    }
}
