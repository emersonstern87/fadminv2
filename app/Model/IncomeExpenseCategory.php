<?php

namespace App\Model;
use DB;
use Illuminate\Database\Eloquent\Model;

class IncomeExpenseCategory extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'category_type'];

    public function generalLedgers()
    {
        return $this->hasMany("App\Model\GeneralLedger", 'gl_account_id');
    }

    public function expense() 
    {
      return $this->hasOne("App\Model\Expense", 'income_expense_category_id');
    }
    
    public function deposit() 
    {
      return $this->hasOne("App\Model\Deposit", 'income_expense_category_id');
    }
}
