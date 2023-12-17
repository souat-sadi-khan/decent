<?php

namespace App\models\employee;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Designation extends Model
{
    use SoftDeletes;
    protected $table="designations";

    public function category(){
        return $this->belongsTo(EmployeeCategory::class,'employee_category_id','id');
    }
    public function designation(){
        return $this->belongsTo(Designation::class,'top_designation_id','id');
    }
     function employee_designation(){
    	return $this->hasMany(EmployeeDesignation::class);
    }
}
