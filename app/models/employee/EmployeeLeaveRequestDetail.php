<?php

namespace App\models\employee;

use Illuminate\Database\Eloquent\Model;

class EmployeeLeaveRequestDetail extends Model
{
    function employee()
    {
        return $this->belongsTo(Employee::class, 'approver_user_id', 'user_id');
    }
}
