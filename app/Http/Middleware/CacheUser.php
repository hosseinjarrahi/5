<?php

namespace App\Http\Middleware;

use Closure;

class CacheUser
{
    public function handle($request, Closure $next)
    {
        return $next($request);
    }
}
