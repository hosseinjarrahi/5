<?php

namespace Quizviran\Http\Middleware;

use Closure;
use Quizviran\Repositories\RoomRepo;

class HasRoom
{
    public function handle($request, Closure $next)
    {
        if ($request->route()->room) {
            $room = RoomRepo::getFromLink($request->route()->room);
        } else {
            $room = RoomRepo::findOrFail($request->id);
        }

        cache()->set('room',$room);

        if (auth()->user()->hasRoom($room)) {
            return $next($request);
        }

        return abort(404);
    }
}
