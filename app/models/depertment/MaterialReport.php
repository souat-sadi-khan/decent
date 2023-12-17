<?php

namespace App\models\depertment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaterialReport extends Model
{
    use SoftDeletes;

    public function material(){
        return $this->belongsTo('App\models\Production\RawMaterial','raw_material_id','id');
   }

   public function depertment(){
        return $this->belongsTo('App\models\depertment\Depertment');
   }

    public function accept_by(){
        return $this->belongsTo('App\User','created_by','id');
   }
}
