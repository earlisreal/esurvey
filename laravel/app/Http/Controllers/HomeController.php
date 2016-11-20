<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verify');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::guest()){
            return view('welcome');
        }else{
            $this->show();
        }
    }

    public function show()
    {
        if(Auth::user()->role->title === "User"){
            //$surveys = Auth::user()->surveys()->all();
            return redirect('mysurveys');
        }else{
            if(Auth::user()->role->modules->where('pivot.can_read', 1)->count() < 1){
                return redirect('mysurveys');
            }
            return redirect('admin/'.Auth::user()->role->modules->where('pivot.can_read', 1)->first()->url);
        }
    }

    public function mySurveys(){
        $surveys = Auth::user()
            ->surveys()
            ->where('is_template', false)
            ->orderBy('updated_at', 'desc')
            ->orderBy('survey_title')
            ->get();
        return view('survey.mySurveys', [
            'surveys' => $surveys,
            'eDate' => new Edate()
        ]);
    }
}

class Edate extends Carbon {
    public function toDateWithTime($date){
        return self::parse($date)->format('F d, Y h:i:s A');
    }

    public function toDate($date){
        return self::parse($date)->format('F d, Y');
    }
}
