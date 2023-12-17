<?php

namespace App\models\employee;

use Illuminate\Database\Eloquent\Model;

class PayrollTemplateDetail extends Model
{
    function attendance_type()
    {
        return $this->belongsTo(EmployeeAttendanceType::class, 'employee_attendance_type_id', 'id');
    }

    function payhead()
    {
        return $this->belongsTo(PayHead::class, 'pay_head_id', 'id');
    }

}
