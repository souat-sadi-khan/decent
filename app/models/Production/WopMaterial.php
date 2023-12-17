<?php

namespace App\models\Production;

use Illuminate\Database\Eloquent\Model;

class WopMaterial extends Model
{
    public function work_order()
    {
        return $this->belongsTo(WorkOrder::class, 'wo_id', 'id');
    }

    public function work_order_product()
    {
        return $this->belongsTo(WorkOrderProduct::class, 'wop_id', 'id');
    }

    public function raw_material()
    {
        return $this->belongsTo(RawMaterial::class, 'raw_material_id', 'id');
    }
}
