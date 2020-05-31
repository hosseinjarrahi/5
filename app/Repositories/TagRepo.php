<?php

namespace App\Repositories;

use Conner\Tagging\Model\Tag;

class TagRepo
{
    public static function findBySlug($slug)
    {
        return Tag::where('slug', $slug)->first();
    }
}
