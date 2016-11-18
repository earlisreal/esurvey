<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $fillable = ['title'];

    public function modules(){
        return $this->belongsToMany(Module::class, 'role_modules', 'role_id', 'module_id')
            ->withPivot('can_read', 'can_write', 'id');
    }


    public function rights($module){
        return array(
            'read' => $this->modules()
                ->where('title', $module)->get()
                ->first()
                ->pivot->can_read,
            'write' => $this->modules()
                ->where('title', $module)->get()
                ->first()
                ->pivot->can_write

        );

    }

    public function users(){
        return $this->hasMany(User::class, 'role_id');
    }
}
