<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeShift extends Model
{
    use SoftDeletes;

    protected $guarded = [];
}
