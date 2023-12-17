<?php

namespace App\models\Production;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RawMaterial extends Model{
    use SoftDeletes;

    public function unit(){
        return $this->belongsTo(Unit::class);
    }

    public function clients()
    {
    	return $this->belongsToMany('App\models\Client')->withTimestamps();
    }
}
