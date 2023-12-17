<?php

namespace App\models\Production;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionPayment extends Model
{
     protected $guarded = ['id'];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'id');
    }

    
    public function client()
    {
        return $this->belongsTo('App\models\Client','client_id','id');
    }

      public function employee()
    {
        return $this->belongsTo('App\models\employee\Employee','employee_id','id');
    }

      public function self_payment()
    {
        return $this->hasMany(TransactionPayment::class, 'transaction_id', 'id');
    }

    public function free_trans()
    {
    
         return $this->transaction->where('hidden',false);
        
    }


    /**
     * Get the phone record associated with the user.
     */
    public function payment_account()
    {
        return $this->belongsTo('App\models\account\Account', 'account_id');
    }

    public function pay_investment()
    {
        return $this->belongsTo('App\models\account\InvestmentAccount', 'investment_account_id');
    }
}
