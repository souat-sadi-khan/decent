<?php

namespace App\models\inventory;

use Illuminate\Database\Eloquent\Model;

class TransactionSellLine extends Model
{
   protected $guarded = ['id'];

    public function transaction()
    {
        return $this->belongsTo('App\models\Poduction\Transaction');
    }

    public function product()
    {
        return $this->belongsTo('App\models\Production\Product','product_id');
    }

   public function variation(){
        return $this->belongsTo('App\models\Production\Variation');
   }

    public function returnsale() {
        return $this->hasMany('App\models\inventory\ReturnTransaction');
    }

}
