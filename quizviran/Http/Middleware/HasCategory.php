<?php

namespace Quizviran\Http\Middleware;

use Closure;

class HasCategory
{
    public function handle($request, Closure $next)
    {
        if(auth()->user()->hasCategory($request->route()->category->user_id))
            return $next($request);

        return abort(404);
    }
}
