<?php

namespace App\models\employee;

use Illuminate\Database\Eloquent\Model;

class PayrollTemplate extends Model
{
    function details()
    {
        return $this->hasMany(PayrollTemplateDetail::class, 'payroll_template_id', 'id');
    }
}
