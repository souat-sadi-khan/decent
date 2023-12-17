<?php

namespace App\models\employee;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeAttendance extends Model
{
    use SoftDeletes;

    function attendance_type()
    {
        return $this->belongsTo(EmployeeAttendanceType::class, 'employee_attendance_type_id', 'id');
    }
}
