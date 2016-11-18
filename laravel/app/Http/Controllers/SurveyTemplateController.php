<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Module;
use App\RoleModule;
use App\Survey;
use App\SurveyCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SurveyTemplateController extends Controller
{

    public function __construct()
    {
        $this->middleware('read:templates');
    }

    public function index()
    {
        $user = Auth::user();
        return view('admin.surveyTemplate', [
            'user' => $user,
            'rights' => $user->role->rights('Survey Templates'),
            'surveys' => Survey::where('is_template', 1)->orderBy('updated_at', 'desc')->get(),
            'categories' => $this->getSurveyCategories()
        ]);
    }

    public function show($id)
    {
        $survey = Survey::find($id);
        return view('survey.edit', ['survey' => $survey, 'adminMode' => true]);
    }

    private function getSurveyCategories(){
        return SurveyCategory::where('category', '!=', 'Other')->orderBy('category','asc')->get();
    }

    public function create(){
        return view('admin.template.create', [
            'categories' => $this->getSurveyCategories(),
            'templates' => Survey::where('is_template', 1)->get()
        ]);
    }

    public function display()
    {
        return view('templates', ['categories' => SurveyCategory::all()]);
    }

    public function preview($id){
        $survey = Survey::find($id);
        return view('survey.edit', ['survey' => $survey, 'adminMode' => false]);
    }
}
