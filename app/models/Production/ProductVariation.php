<?php

namespace App\models\Production;

use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    public function variation1()
    {
        return $this->belongsTo(VariationTemplate::class, 'variation_template_id', 'id');
    }
    public function variation2()
    {
        return $this->belongsTo(VariationTemplate::class, 'variation_template_id_2', 'id');
    }
    
    public function variation()
    {
        return $this->hasMany(Variation::class, 'product_variation_id', 'id');
    }
}

