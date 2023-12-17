<?php

namespace App\models\employee;

use Illuminate\Database\Eloquent\Model;

class EmployeeLeaveAllocation extends Model
{
    function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    function allocation_details()
    {
        return $this->hasMany(EmployeeLeaveAllocationDetail::class, 'employee_leave_allocation_id', 'id');
    }
}
