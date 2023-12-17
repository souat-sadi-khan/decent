<?php

namespace App\models\eCommerce;

use App\models\Production\Product;
use App\models\Production\Variation;
use Illuminate\Database\Eloquent\Model;

class EcommerceProduct extends Model
{
    // relationwith product
    public function product() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    // relation with variation
    public function variation() {
        return $this->belongsTo(Variation::class, 'variation_id', 'id');
    }
}
