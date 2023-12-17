<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierMaterial extends Model
{
	use SoftDeletes;
	 protected $table = 'client_raw_material';
     protected $primaryKey = 'id';
    public function material()
    {
    	return $this->belongsToMany('App\models\Production\RawMaterial')->withTimestamps();
    }

   public function raw(){
        return $this->belongsTo('App\models\Production\RawMaterial','raw_material_id','id');
   }
}
