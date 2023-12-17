<?php

namespace App\models\Production;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkOrder extends Model
{
    use SoftDeletes;
    public function work_order()
    {
        return $this->hasMany(WorkOrderProduct::class, 'workorder_id', 'id');
    }
    public function workOrderProduct(){
        return $this->hasMany(WorkOrderProduct::class, 'workorder_id','id');
    }

    public function brand(){
        return $this->belongsTo(Brand::class);
    }

    public function wop_material()
    {
        return $this->hasMany(WopMaterial::class, 'wo_id', 'id');
    }

    public function transaction()
    {
        return $this->belongsTo('App\models\Production\Transaction','work_order_id','id');
    }
}
