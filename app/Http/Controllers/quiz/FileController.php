<?php

namespace App\Http\Controllers\quiz;

use App\File;
use Illuminate\Http\Request;
use App\Http\Requests\UploadRequest;

class FileController extends Controller
{
    public function store(UploadRequest $request)
    {
        $id = auth()->id();
        $this->createFile($request, $id);
        return response(['message' => 'با موفقیت ارسال شد.']);
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

    private function createFile(UploadRequest $request, $id): void
    {
        $file = new File([
            'user_id' => $id,
            'quiz_id' => $request->id
        ]);
        $file->file = $this->uploadFile($request);
        $file->save();
    }
}
