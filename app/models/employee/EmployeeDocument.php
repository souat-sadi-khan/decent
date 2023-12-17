<?php

namespace App\models\employee;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeDocument extends Model
{
    use SoftDeletes;

    public function document_type() {
        return $this->belongsTo(EmployeeDocumentType::class, 'employee_document_type_id', 'id');
    }
}
