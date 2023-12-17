<?php

namespace App\models\employee;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
   use SoftDeletes;
      function employee_designation(){
    	return $this->hasMany(EmployeeDesignation::class);
    }
}
