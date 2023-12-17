<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobCosting extends Model
{
    use SoftDeletes;

    public function cost_material(){
      return $this->hasMany('App\JobCostMaterial');
    }

    public function product(){
        return $this->belongsTo('App\models\Production\Product','product_id','id');
   }
}
