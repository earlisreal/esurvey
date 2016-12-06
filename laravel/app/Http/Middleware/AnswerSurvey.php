<?php

namespace App\Http\Middleware;

use App\Survey;
use Closure;
use Illuminate\Support\Facades\Auth;

class AnswerSurvey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $id, $guard = null)
    {
        $survey = Survey::findOrFail($id);
        if($survey->option->register_required){
            if (Auth::guard($guard)->guest()) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response('Unauthorized.', 401);
                }

                return redirect()->guest('login')->with('warning', 'authenticate');
            }
        }
        return $next($request);
    }
}
