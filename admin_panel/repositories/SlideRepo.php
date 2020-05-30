<?php

namespace Admin\repositories;

use App\Models\Slide;
use Illuminate\Support\Facades\File;

class SlideRepo
{
    public static function all()
    {
        return Slide::all();
    }

    public static function delete($slide)
    {
        File::delete(public_path($slide->pic));
        return $slide->delete();
    }

    public static function create($pic,$link)
    {
        return Slide::create([
            'pic' => $pic,
            'link' => $link,
        ]);
    }
}
