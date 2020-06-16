<?php

namespace App\Http\Middleware;

use Closure;

class AdminCheck
{
    public function handle($request, Closure $next)
    {
        if(auth()->user()->isAdmin())
            return $next($request);
        return abort(404);
    }
}
