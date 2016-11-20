<?php

namespace App\Http\Middleware;

use Closure;

class VerifyIfActivated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->user()->verified)
        return $next($request);

        return redirect('verify');
    }
}
