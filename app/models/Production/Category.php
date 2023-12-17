<?php

namespace App\models\Production;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    public function childs()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function product()
    {
        return $this->hasMany(Product::class);
    }
}
