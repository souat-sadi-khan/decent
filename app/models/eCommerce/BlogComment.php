<?php

namespace App\models\eCommerce;

use Illuminate\Database\Eloquent\Model;

class BlogComment extends Model
{
    public function blog(){
        return $this->belongsTo(BlogPost::class, 'blog_id', 'id');
    }
}
