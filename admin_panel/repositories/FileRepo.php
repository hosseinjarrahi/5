<?php

namespace Admin\repositories;

use App\Models\File;
use Illuminate\Support\Str;

class FileRepo
{
    public static function create($uploadedFile,$path)
    {
        $file = new File();
        $file->name = $uploadedFile->getClientOriginalName();
        $file->path = '/' . $uploadedFile->store($path);
        $file->hash = Str::random(50);
        $file->user_id = auth()->id();
        $file->save();

        return $file;
    }
}
