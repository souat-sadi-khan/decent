<?php

namespace App\models\eCommerce;

use App\models\Production\Product;
use App\models\Production\Variation;
use Illuminate\Database\Eloquent\Model;

class SpecialOfferItem extends Model
{
    // relation lwith product
    public function product() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    // Relatio with variation
    public function variation() {
        return $this->belongsTo(Variation::class, 'variation_id', 'id');
    }
}
