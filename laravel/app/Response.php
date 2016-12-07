<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    protected $fillable = [
        'source_ip', 'source',
    ];

    public function survey(){
        return $this->belongsTo(Survey::class);
    }

    public function responseDetails(){
        return $this->hasMany(ResponseDetail::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
