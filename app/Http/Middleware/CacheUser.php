<?php

namespace App\Http\Middleware;

use Closure;

class CacheUser
{
    public function handle($request, Closure $next)
    {
        cache()->remember('user', 1, function () {
            return auth()->user();
        });

        return $next($request);
    }
}
