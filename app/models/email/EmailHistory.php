<?php

namespace App\models\email;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class EmailHistory extends Model
{
    use SoftDeletes;

     protected $fillable = ["sender_id","email_list","template_id","subject"];

    public function user(){
        return $this->belongsTo('App\User','sender_id','id');
    }

       public function template(){
        return $this->belongsTo('App\models\email\EmailTemolate','template_id','id');
    }
}
