<?php

namespace App\models\Production;

use Illuminate\Database\Eloquent\Model;

class Variation extends Model
{
    public function value1()
    {
        return $this->belongsTo(VariationTemplateDetails::class, 'variation_value_id', 'id');
    }
    public function value2()
    {
        return $this->belongsTo(VariationTemplateDetails::class, 'variation_value_id_2', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
