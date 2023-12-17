<?php

namespace App\models\employee;

use Illuminate\Database\Eloquent\Model;

class EmployeeTerm extends Model
{
     function employee_designation(){
    	return $this->belongsTo(EmployeeDesignation::class,'id','employee_term_id');
    }
}
