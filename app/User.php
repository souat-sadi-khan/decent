<?php

namespace App;

use App\models\employee\Employee;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //    'id', 'name', 'user_type','surname','email','first_name','last_name', 'password', 'username', 'phone', 'status','uuid'
    // ];

    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function employee()
    {
        return $this->hasOne('App\models\employee\Employee');
    }

/*    public function getNameAttribute()
    {
        $profile = $this->getProfile();

        return $profile->first_name . ' ' . $profile->middle_name . ' ' . $profile->last_name;
    }*/

    public function getProfileAttribute()
    {

        if ($this->hasRole('client')) {
            $profile = $this->Client;
        } else {
            $profile = $this->Employee;
        }


        return $profile;
    }

// /*    public function getNameWithEmailAttribute()
//     {
//         $profile = $this->getProfile();

//         return $profile->first_name . ' ' . $profile->middle_name . ' ' . $profile->last_name . ' (' . $this->email . ')';
//     }*/

//     public function client()
//     {
//         return $this->hasOne('App\models\Client');
//     }

    public function getNameAttribute() {
		// $profile = $this->getProfile();
		// return ($profile->first_name ? $profile->first_name : '') . ($profile->middle_name ? ' ' . $profile->middle_name : '') . ($profile->last_name ? ' ' . $profile->last_name : '');
	}

	public function getNameWithEmailAttribute() {
		// $profile = $this->getProfile();

		return $profile->first_name . ' ' . $profile->middle_name . ' ' . $profile->last_name . ' (' . $this->email . ')';
    }


    function employeedata()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

}
