<?php

namespace App\Http;

use Morilog\Jalali\Jalalian;
use Illuminate\Support\Facades\File;

class Upload
{
    const BASE_PATH = '/upload';

    public static function uploadFile($files)
    {
        $folder = Jalalian::forge(date('y-m-d'))->format('y-m');
        $files = (Array)$files;
        $path = null;
        $allPath = [];
        foreach ($files as $key => $file) {
            $fileName =  time() . random_int(10, 5000) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path(self::BASE_PATH . '/' . $folder), $fileName);
            $allPath[$key] = '/upload/'. $folder . '/' . $fileName;
        }

        return $allPath;
    }

    public static function delete()
    {

    }
//    private function createFile($request, $id)
//    {
//        $file = new File([
//            'user_id' => $id,
//            'quiz_id' => $request->id,
//        ]);
//        $file->file = $this->uploadFile($request);
//        $file->save();
//    }
}