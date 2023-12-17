<?php

namespace App\models\employee;

use Illuminate\Database\Eloquent\Model;

class EmployeeLeaveAllocationDetail extends Model
{
    function leave_type()
    {
        return $this->belongsTo(EmployeeLeaveType::class , 'employee_leave_type_id', 'id');
    }

    function employee()
    {
        return $this->belongsTo(EmployeeLeaveAllocation::class, 'employee_leave_allocation_id', 'id');
    }
}
