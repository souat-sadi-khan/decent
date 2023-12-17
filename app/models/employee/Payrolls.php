<?php

namespace App\models\employee;

use Illuminate\Database\Eloquent\Model;

class Payrolls extends Model
{
    // relation with salary structure
    public function salary() {
        return $this->belongsTo(EmployeeSalary::class, 'employee_salary_id', 'id');
    }
}
