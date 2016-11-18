<?php

namespace App\Http\Controllers;

use App\SurveyCategory;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class SurveyCategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('read:categories');
    }

    public function index(){
        return view('admin.survey-categories', [
            'categories' => SurveyCategory::all(),
            'right' => Auth::user()->role->modules()->where('url', 'categories')->first()->pivot,
        ]);
    }

    public function store(Request $request){
        $this->validate($request, [
            'category' => 'required|max:255',
        ]);

        SurveyCategory::create([
           'category' => $request->category
        ]);

        return redirect('admin/categories')->with('status', 'New Survey Category has been Added!');
    }

    public function destroy($id){
        SurveyCategory::find($id)->delete();

        return redirect('/admin/categories')->with('status', 'A Survey Category has been removed!');
    }

    public function update($id, Request $request){
        SurveyCategory::find($id)->update([
            'category' => $request->category
        ]);

        return redirect('/admin/categories')->with('status', 'Survey Category has been updated!');
    }
}
