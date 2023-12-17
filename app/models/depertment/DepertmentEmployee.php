<?php

namespace App\models\depertment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DepertmentEmployee extends Model
{
     use SoftDeletes;

    public function employee(){
        return $this->belongsTo('App\models\employee\Employee');
    }
}
