<?php

namespace App\models\eCommerce;
 use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class HomePage extends Model{
    use SoftDeletes;
    protected $guarded  = [];
    public function product(){
        return $this->belongsTo('App\models\production\product');
    }
}
