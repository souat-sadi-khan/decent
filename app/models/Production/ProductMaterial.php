<?php

namespace App\models\Production;

use Illuminate\Database\Eloquent\Model;

class ProductMaterial extends Model
{
    public function material()
    {
        return $this->belongsTo(RawMaterial::class, 'material_id', 'id');
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
