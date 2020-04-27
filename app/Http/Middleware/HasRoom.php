<?php

namespace App\Http\Middleware;

use Closure;
use Quizviran\Repositories\RoomRepo;

class HasRoom
{
    public function handle($request  , Closure $next)
    {
        $room = RoomRepo::getFromLink($request->route()->room);

        if(auth()->user()->hasRoom($room))
            return $next($request);

        return abort(404);
    }
}
