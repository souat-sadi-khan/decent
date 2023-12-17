<?php

namespace App\models\Production;

use App\models\employee\Employee;
use App\models\User;
use App\Qurier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;
     protected $guarded = ['id'];

    public function qurier() {
        return $this->belongsTo(Qurier::class, 'qurier_id', 'id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'purchase_by', 'id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function work_order()
    {
        return $this->belongsTo(WorkOrder::class, 'work_order_id', 'id');
    }

    public function purchase()
    {
        return $this->hasMany(Purchase::class, 'transaction_id', 'id');
    }

    public function payment()
    {
        return $this->hasMany(TransactionPayment::class, 'transaction_id', 'id');
    }

    public function sell_lines()
    {
        return $this->hasMany('App\models\inventory\TransactionSellLine');
    }

    public function job_works()
    {
        return $this->hasMany('App\JobWork');
    }

    public function client()
    {
        return $this->belongsTo('App\models\Client');
    }

    public function return_parent()
    {
        return $this->hasOne(Transaction::class, 'return_parent_id');
    }

    public function return_trans()
    {
        return $this->belongsTo(Transaction::class, 'return_parent_id');
    }

    public function created_person()
    {
        return $this->belongsTo('App\User', 'created_by');
    }

   public function returntransaction() {
        return $this->hasMany('App\models\inventory\ReturnTransaction');
    }


}
