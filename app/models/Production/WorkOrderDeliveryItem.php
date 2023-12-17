<?php

namespace App\models\Production;

use Illuminate\Database\Eloquent\Model;

class WorkOrderDeliveryItem extends Model
{
    // relation with product
    public function product() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    // relation with variation
    public function variation() {
        return $this->belongsTo(Variation::class, 'variation_id', 'id');
    }
}
