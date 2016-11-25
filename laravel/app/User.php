<?php

namespace App;

use App\Survey;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'first_name',
        'last_name',
        'email',
        'password',
        'role_id',
        'verified',
        'activation_code',
        'phone',
        'gender',
        'country',
        'state',
        'city',
        'birthday',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function surveys()
    {
        return $this->hasMany(Survey::class);
    }

    public function role()
    {
        return $this->belongsTo(UserRole::class);
    }

    public function picture()
    {
        if (file_exists('public/images/users/user' . $this->id . '.png')) {
            return asset('public/images/users/user' . $this->id . '.png');
        } else {
            return asset('public/images/guest.png');
        }
    }


}
