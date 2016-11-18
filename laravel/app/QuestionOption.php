<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionOption extends Model
{
    protected $fillable = [
        'max_rating',
    ];

    protected $touches = ['question'];

    public function question(){
        return $this->belongsTo(Question::class);
    }


    public $timestamps = false;
}
