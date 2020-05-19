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
        $file = File::where('hash', $request->hash)->firstOrFail();

        return Storage::download($file->path, $file->name);
    }

    public function store(UploadRequest $request)
    {
        if ($request->base64) {
            $file = $this->saveMp3(request()->base64);
        } else {
            $file = $this->createFile($request);
        }

        return response([
            'message' => 'با موفقیت ارسال شد.',
            'file' => [
                'id' => $file->id,
                'name' => $file->name,
            ],
        ]);
    }

    public function destroy(File $file)
    {
        if (! ($file && $file->isOwn())) {
            return response(['message' => 'چنین فایلی وجود ندارد.']);
        }
        FileFacade::delete(storage_path('app/' . $file->path));
        $file->delete();

        return response(['message' => 'با موفقیت حذف شد.']);
    }

    private function createFile(UploadRequest $request)
    {
        $folder = $this->createFolder();
        $path = 'files/' . $folder;
        $filename = Str::random(20) . '.' . $request->file->getClientOriginalExtension();

        return File::create([
            'user_id' => auth()->id(),
            'path' => $request->file->storeAs($path, $filename),
            'hash' => Str::random(50),
            'name' => $request->file->getClientOriginalName(),
            'password' => $request->password,
        ]);
    }

    private function saveMp3($base64)
    {
        $name = Str::random(15) . '.mp3';
        $folder = $this->createFolder();
        $path = "files/{$folder}/{$name}";
        $base64 = Str::of($base64)->after('data:audio/mp3;base64,');
        $audio = base64_decode($base64,true);

        file_put_contents("temp/{$name}", $audio);

        FileFacade::move(public_path("temp/{$name}"), storage_path('app'.DIRECTORY_SEPARATOR.$path));

        return File::create([
            'user_id' => auth()->id(),
            'path' => $path,
            'hash' => Str::random(50),
            'name' => $name,
        ]);
    }

    private function createFolder()
    {
        return Jalalian::forge(date('y-m-d'))->format('y-m');
    }
}
