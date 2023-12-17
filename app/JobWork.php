<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobWork extends Model
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
        return $this->belongsTo('App\models\depertment\Depertment','send_depertment_id','id');
   }

    public function accept_depertment(){
        return $this->belongsTo('App\models\depertment\Depertment','depertment_id','id');
   }

    public function product_flow(){
      return $this->hasMany('App\models\depertment\ProductFlow');
    }
}
