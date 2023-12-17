<?php

namespace App\models\eCommerce;

use App\models\Production\Category;
use Illuminate\Database\Eloquent\Model;

class SpecialCategory extends Model
{
    // Relation with special category
    public function category() {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
