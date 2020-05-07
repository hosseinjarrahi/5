<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Support\Str;
use Morilog\Jalali\Jalalian;
use Illuminate\Http\Request;
use App\Http\Requests\UploadRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File as FileFacade;

class FileController extends Controller
{
    public function index(Request $request)
    {
        // todo : password check
        $file = File::where('hash',$request->hash)->firstOrFail();

        return Storage::download($file->path,$file->name);
    }

    public function store(UploadRequest $request)
    {
        $file = $this->createFile($request);
        return response(['message' => 'با موفقیت ارسال شد.','file' => ['id' => $file->id , 'name' => $file->name]]);
    }

    public function destroy(File $file)
    {
        if(!($file && $file->isOwn()))
            return response(['message' => 'چنین فایلی وجود ندارد.']);
        FileFacade::delete(storage_path('app/'.$file->path));
        $file->delete();
        return response(['message' => 'با موفقیت حذف شد.']);
    }

    private function createFile(UploadRequest $request)
    {
        $folder = Jalalian::forge(date('y-m-d'))->format('y-m');
        $path = 'files/'. $folder;
        $filename = Str::random(20) . '.' . $request->file->getClientOriginalExtension();

        return File::create([
            'user_id' => auth()->id(),
            'path' => $request->file->storeAs($path,$filename),
            'hash' => Str::random(50),
            'name' => $request->file->getClientOriginalName(),
            'password' => $request->password
        ]);
    }
}
