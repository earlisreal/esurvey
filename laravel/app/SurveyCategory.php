<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveyCategory extends Model
{
    public function surveys(){
        return $this->hasMany(Survey::class, 'category_id');
    }

    protected $fillable = ['category'];
}
