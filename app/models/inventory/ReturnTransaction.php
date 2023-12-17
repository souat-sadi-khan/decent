<?php

namespace App\models\inventory;

use Illuminate\Database\Eloquent\Model;

class ReturnTransaction extends Model
{
    public function sales(){
    	return $this->belongsTo('App\models\inventory\TransactionSellLine', 'transaction_sell_line_id');
    }
}
