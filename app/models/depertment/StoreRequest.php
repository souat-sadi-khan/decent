<?php

namespace App\models\depertment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StoreRequest extends Model
{
   use SoftDeletes;
    public function material(){
        return $this->belongsTo('App\models\Production\RawMaterial','raw_material_id','id');
   }

   public function work_order(){
        return $this->belongsTo('App\models\Production\WorkOrder');
   }

   public function depertment(){
        return $this->belongsTo('App\models\depertment\Depertment');
   }

  public function send_by(){
        return $this->belongsTo('App\User','created_by','id');
   }

  public function approve_store_item(){
      return $this->hasMany(ApproveStoreItem::class);
    }
}
