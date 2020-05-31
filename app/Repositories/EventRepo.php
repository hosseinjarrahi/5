<?php

namespace App\Repositories;

use App\Models\Event;

class EventRepo
{
    public static function all()
    {
        return Event::all();
    }
}
