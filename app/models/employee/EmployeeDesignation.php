<?php

namespace App\models\employee;

use Illuminate\Database\Eloquent\Model;

class EmployeeDesignation extends Model
{
    function employee(){
    	return $this->belongsTo(Employee::class);
    }
    function department(){
    	return $this->belongsTo(Department::class);
    }
    
    function designation(){
    	return $this->belongsTo(Designation::class, 'designation_id', 'id');
    }

    function terms(){
    	return $this->belongsTo(EmployeeTerm::class,'employee_term_id','id');
    }
}
