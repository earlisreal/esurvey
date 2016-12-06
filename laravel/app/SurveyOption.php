<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveyOption extends Model
{
    protected $fillable = [
        'survey_id',
        'open',
        'closed_message',
        'multiple_responses',
        'target_responses',
        'date_close',
        'response_message',
        'register_required',
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public $timestamps = false;

    protected $touches = ['survey'];
}
