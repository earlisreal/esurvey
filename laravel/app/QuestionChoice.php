<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionChoice extends Model
{
    protected $fillable = [
        'label', 'weight',
    ];

    protected $touches = ['question'];

    public function question(){
        return $this->belongsTo(Question::class);
    }

    public function reponseDetails(){
        return $this->hasMany(ResponseDetail::class);
    }
}
