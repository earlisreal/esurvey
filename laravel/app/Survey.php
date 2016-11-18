<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $fillable = [
        'survey_title', 'survey_id', 'updated_at', 'published', 'is_template',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function category(){
        return $this->belongsTo(SurveyCategory::class);
    }

    public function pages(){
        return $this->hasMany(SurveyPage::class);
    }

    public function questions(){
        return $this->hasMany(Question::class);
    }

    public function responses(){
        return $this->hasMany(Response::class);
    }

    public function option()
    {
        return $this->hasOne(SurveyOption::class);
    }

    public function getQuestionCount(){
        $count = 0;
        foreach ($this->pages() as $page){
            $count += $page->questions->count();
        }
        return $count;
    }
}
