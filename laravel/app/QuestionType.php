<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionType extends Model
{
    protected $fillable = [
        'has_choices', 'type', 'html', 'logo',
    ];

    public function questions(){
        return $this->hasMany(Question::class);
    }
}
