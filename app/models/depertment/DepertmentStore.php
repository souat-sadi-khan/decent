<?php

namespace App\models\depertment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DepertmentStore extends Model
{
    use SoftDeletes;

   public function depertment(){
        return $this->belongsTo('App\models\depertment\Depertment');
   }

  public function send_by(){
        return $this->belongsTo('App\User','created_by','id');
   }

    function store_request(){
    	return $this->hasMany(StoreRequest::class);
    }
}
