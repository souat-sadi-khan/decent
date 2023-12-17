<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobCostMaterial extends Model
{
    use SoftDeletes;

   public function category(){
        return $this->belongsTo('App\models\Production\IngredientsCategory','ingredients_category_id','id');
   }

   public function raw(){
        return $this->belongsTo('App\models\Production\RawMaterial','raw_material_id','id');
   }

    public function unit_name(){
        return $this->belongsTo('App\models\Production\Unit','unit_id','id');
   }
}
