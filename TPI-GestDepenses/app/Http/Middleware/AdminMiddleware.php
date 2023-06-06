<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (auth()->check() && auth()->user()->idrole === 1) {
            return $next($request);
        }

        abort(403, 'Accès refusé.'); // Ou redirigez vers une page d'erreur ou de connexion
    }
}
