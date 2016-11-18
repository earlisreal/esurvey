<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

use Log;

class ReadMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $module)
    {
        if(!$request->user()->role->modules()->where('url', $module)->first()->pivot->can_read){
            return redirect('home');
        }
        return $next($request);
    }
}
