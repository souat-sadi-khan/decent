<?php

namespace App\models\Expense;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use SoftDeletes;

    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class,'expense_category_id','id');
    }

     public function investment()
    {
        return $this->belongsTo('App\models\account\InvestmentAccount','investment_account_id','id');
    }

    public function employee()
    {
        return $this->belongsTo('App\models\employee\Employee','employee_id','id');
    }

      public function user(){
        return $this->belongsTo('App\User','created_by','id');
   }
}
