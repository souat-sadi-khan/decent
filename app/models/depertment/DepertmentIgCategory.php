<?php

namespace App\models\depertment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DepertmentIgCategory extends Model
{
   use SoftDeletes;

    public function ingcategory(){
        return $this->belongsTo('App\models\production\IngredientsCategory','ingredients_category_id','id');
    }
}
