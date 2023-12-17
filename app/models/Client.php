<?php

namespace App\models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\MemberResetPasswordNotification;

class Client extends Authenticatable
{
    use SoftDeletes;
	use Notifiable;

    protected $guard = 'member';
    protected $guarded = [];


    // public function sentpasswordresetnotification($token){
	// 	$this->notify(new MemberResetPasswordNotification($token));
	// }
}
