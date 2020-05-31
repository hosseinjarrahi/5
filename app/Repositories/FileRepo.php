<?php

namespace App\Repositories;

use App\Models\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File as FileFacade;

class FileRepo
{
    public static function findByHash($hash)
    {
        return File::where('hash', $hash)->firstOrFail();
    }

    public static function downloadIncrement($file)
    {
        $file->download++;
        return $file->save();
    }

    public static function delete($file)
    {
        FileFacade::delete(storage_path('app/' . $file->path));
        return $file->delete();
    }

    public static function create($name,$filePath,$password = null)
    {
        return File::create([
            'user_id' => auth()->id(),
            'path' => $filePath,
            'hash' => Str::random(50),
            'name' => $name,
            'password' => $password,
        ]);
    }
}
