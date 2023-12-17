<?php

namespace App\models\employee;

use Illuminate\Database\Eloquent\Model;

class EmployeeAccount extends Model
{
    function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
