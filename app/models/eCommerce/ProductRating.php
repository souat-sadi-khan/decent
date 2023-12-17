<?php

namespace App\models\eCommerce;

use App\models\Production\Product;
use App\User;
use Illuminate\Database\Eloquent\Model;

class ProductRating extends Model
{
     protected $guarded  = [];

     public function product()
     {
          return $this->belongsTo(Product::class, 'product_id', 'id');
     }
     public function user()
     {
          return $this->belongsTo(User::class, 'user_id', 'id');
     }
}
