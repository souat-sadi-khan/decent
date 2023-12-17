<?php

namespace App\models\sms;

use Illuminate\Database\Eloquent\Model;

class Smslog extends Model
{
    protected $fillable = [
        'sender_id', 'to', 'message', 'status',
    ];

   public function user(){
        return $this->belongsTo('App\User','sender_id','id');
    }
}
