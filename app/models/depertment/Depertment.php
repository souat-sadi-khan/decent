<?php

namespace App\models\depertment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Depertment extends Model
{
    use SoftDeletes;

    public function employee(){
        return $this->belongsTo('App\models\employee\Employee');
    }

    function depertment_employee(){
    	return $this->hasMany(DepertmentEmployee::class);
    }

    function igcategory(){
    	return $this->hasMany(DepertmentIgCategory::class);
    }

    function store_request(){
        return $this->hasMany(StoreRequest::class);
    }

   function depertment_request(){
        return $this->hasMany(DepertmentStore::class);
    }
}
