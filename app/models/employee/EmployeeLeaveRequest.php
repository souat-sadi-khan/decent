<?php

namespace App\models\employee;

use App\models\User;
use Illuminate\Database\Eloquent\Model;

class EmployeeLeaveRequest extends Model
{
    function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    function request_details()
    {
        return $this->hasMany(EmployeeLeaveRequestDetail::class, 'employee_leave_request_id', 'id');
    }

    function leave_type()
    {
        return $this->belongsTo(EmployeeLeaveType::class, 'employee_leave_type_id', 'id');
    }

    function request()
    {
        return $this->belongsTo(User::class, 'requester_user_id','id');
    }
}
