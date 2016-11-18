<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    public function roles(){
        return $this->belongsToMany(UserRole::class, 'role_modules', 'module_id', 'role_id');
    }
}
