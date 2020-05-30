<?php

namespace Admin\repositories;

use Conner\Tagging\Model\Tag;

class TagRepo
{
    public static function all()
    {
        return Tag::all();
    }
}
