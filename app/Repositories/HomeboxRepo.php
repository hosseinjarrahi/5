<?php

namespace App\Repositories;

use App\Models\HomeBox;

class HomeboxRepo
{
    public static function hasCategory()
    {
        return HomeBox::whereHas('category')->get();
    }
}
