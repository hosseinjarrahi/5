<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Http\Upload;
use Illuminate\Http\Request;
use App\Http\Requests\UploadRequest;

class FileController extends Controller
{
    public function store(UploadRequest $request)
    {
        $file = $this->createFile($request);
        return response(['message' => 'با موفقیت ارسال شد.','file' => ['id' => $file->id , 'file' => $file->file]]);
    }

    private function uploadFile(UploadRequest &$request)
    {
        $file = $request->file('file');
        $path = null;
        if ($request->hasFile('file') && ! is_null($request->file)) {
            $path = time() . random_int(10, 5000) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload'), $path);
        }
        return $path ? 'upload/' . $path : null;
    }

    public function destroy(File $file)
    {
        if(!$file || !$file->isOwn())
            return response(['message' => 'چنین فایلی وجود ندارد.']);
        \Illuminate\Support\Facades\File::delete($file->file);
        return response(['message' => 'با موفقیت حذف شد.']);
    }

    private function createFile($request)
    {
        return File::create([
            'user_id' => auth()->id(),
            'file' => Upload::uploadFile(['file' => $request->file])['file']
        ]);
    }
}
