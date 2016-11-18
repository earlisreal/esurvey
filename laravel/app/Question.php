<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'question_title', 'order_no', 'survey_page_id', 'question_type_id', 'is_mandatory',
    ];

    protected $touches = ['surveyPage'];

    public function surveyPage(){
        return $this->belongsTo(SurveyPage::class);
    }

    public function questionType(){
        return $this->belongsTo(QuestionType::class);
    }

    public function option(){
        return $this->hasOne(QuestionOption::class);
    }

    public function choices(){
        return $this->hasMany(QuestionChoice::class);
    }

    public function responses(){
        return $this->hasMany(ResponseDetail::class);
    }

//    public function generateForm(){
//        $form = '';
//        switch ($this->questionType()->type){
//            case "Multiple Choice":
//                foreach ($this->choices as $choice){
//                    $form .= '<div class="radio choice-row" data-choice-id="' .$choice->id .'">
//                                 <label class="choice-label"><input type="radio"> '.$choice->label .'</label>
//                            </div>';
//                }
//                break;
//            case "Dropdown":
//                $form .= '<select class="form-control">';
//                foreach($this->choices as $choice){
//                    $form .= '<option class="choice-row choice-label" data-choice-id="' .$choice->id .'">' .$choice->label .'</option>';
//                }
//                $form .= '</select>';
//                break;
//            case "Checkbox":
//                foreach($this->choices as $choice){
//                    $form .= '<div class="checkbox choice-row" data-choice-id="' .$choice->id .'">
//                                <label class="choice-label"><input type="checkbox"> ' .$choice->label .'</label>
//                            </div>';
//                }
//                break;
//            case "Textbox":
//                $form = '<div class="form-group">
//                            <input type="text" class="form-control">
//                        </div>';
//                break;
//            case "Text Area":
//                $form = '<div class="form-group">
//                            <textarea cols="30" rows="2" class="form-control"></textarea>
//                        </div>';
//                break;
//            default:
//                //
//        }
//        return $form;
//    }
}
