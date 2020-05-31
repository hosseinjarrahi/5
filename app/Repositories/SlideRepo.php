<?php

namespace App\Repositories;

use App\Models\Slide;

class SlideRepo
{
    public static function all()
    {
        return Slide::all();
    }
}
