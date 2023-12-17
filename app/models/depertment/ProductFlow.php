<?php

namespace App\models\depertment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductFlow extends Model
{
     use SoftDeletes;

   public function variation(){
        return $this->belongsTo('App\models\Production\Variation');
   }

   public function work_order(){
        return $this->belongsTo('App\models\Production\WorkOrder');
   }

   public function product(){
        return $this->belongsTo('App\models\Production\Product','product_id','id');
   }

   public function send_by(){
        return $this->belongsTo('App\User','created_by','id');
   }

   public function send_depertment(){
        return $this->belongsTo(Depertment::class,'send_depertment_id','id');
   }

   public function depertment(){
        return $this->belongsTo(Depertment::class,'depertment_id','id');
   }
}
