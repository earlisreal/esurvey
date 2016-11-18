<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleModule extends Model
{
    protected $fillable = [
        'role_id', 'module_id', 'can_read', 'can_write'
    ];
}
