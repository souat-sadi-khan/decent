<?php

namespace App\models\eCommerce;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id', 'id');
    }
}
