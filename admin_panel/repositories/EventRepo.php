<?php

namespace Admin\repositories;

use App\Models\Event;
use Morilog\Jalali\Jalalian;

class EventRepo
{
    public static function all()
    {
        return Event::all();
    }

    public static function delete($event)
    {
        return $event->delete();
    }

    public static function create($request)
    {
        return EventRepo::create([
            'type' => $request['type'],
            'start' => Jalalian::fromFormat('Y/m/d h:i', $request->start)->toCarbon(),
            'end' => Jalalian::fromFormat('Y/m/d h:i', $request->end)->toCarbon(),
            'body' => $request['body'],
        ]);
    }
}
