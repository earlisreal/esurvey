<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResponseDetail extends Model
{
    protected $fillable = [
        'text_answer',
    ];

    public function response(){
        return $this->belongsTo(Response::class);
    }

    public function question(){
        return $this->belongsTo(Question::class);
    }

    public function choice(){
        return $this->belongsTo(QuestionChoice::class);
    }

    public function row(){
        return $this->belongsTo(QuestionRow::class);
    }
}
