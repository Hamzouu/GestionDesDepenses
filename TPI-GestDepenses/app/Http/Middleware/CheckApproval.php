<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckApproval
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next)
    {
        
        if (Auth::check() && !Auth::user()->approved && !request()->is('waiting-approval')) {
            return redirect('/waiting-approval');
        }

        return $next($request);
    }
}

