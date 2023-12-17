<?php

namespace App\models\employee;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
   function emp_designation(){
    	return $this->hasMany(EmployeeDesignation::class);
    }

    public function designation() {
        return $this->belongsTo(Designation::class);
    }


}
