<?php

namespace App;

use App\models\Production\Product;
use Illuminate\Database\Eloquent\Model;

class EcommerceOffer extends Model
{
    //
    public function product() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
