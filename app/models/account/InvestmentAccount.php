<?php

namespace App\models\account;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvestmentAccount extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];


     public function expense()
    {
        return $this->hasMany('App\models\Expense\Expense');
    }

}
