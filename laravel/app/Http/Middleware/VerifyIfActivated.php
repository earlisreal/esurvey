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
        if(!$request->user()->verified){
            return redirect('verify');
        }

        if ($request->user()->role->id == 2 && ! $request->user()->subscribed('main')) {
            // This user is not a paying customer...
            return redirect('subscription');
        }

        return $next($request);
    }
}
