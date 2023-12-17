<?php

namespace App\models\eCommerce;

use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    public function post()
    {
        return $this->hasMany(BlogPost::class);
    }
}
