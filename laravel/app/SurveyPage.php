<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveyPage extends Model
{
    protected $fillable = [
        'survey_id', 'page_no', 'page_title', 'page_description',
    ];

    protected $touches = ['survey'];

    public function survey(){
        return $this->belongsTo(Survey::class);
    }

    public function questions(){
        return $this->hasMany(Question::class);
    }
}
