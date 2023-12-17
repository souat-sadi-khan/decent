<?php

namespace App\models\eCommerce;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model{
     use SoftDeletes;
    protected $guarded  = [];
    
}
