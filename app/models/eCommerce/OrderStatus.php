<?php

namespace App\models\eCommerce;

use App\models\User;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
