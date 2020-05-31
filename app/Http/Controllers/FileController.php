<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Repositories\FileRepo;
use App\Http\Requests\UploadRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File as FileFacade;

class FileController extends Controller
{
    public function index(Request $request)
    {
        /**
         * @get('/file')
         * @name('file.index')
         * @middlewares(web)
         */
        // todo : password check
        $file = FileRepo::findByHash($request->hash);
        FileRepo::downloadIncrement($file);

        return Storage::download($file->path, $file->name);
    }

    public function store(UploadRequest $request)
    {
        /**
         * @post('/file')
         * @name('file.store')
         * @middlewares(web)
         */
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
        /**
         * @delete('/file/{file}')
         * @name('file.destroy')
         * @middlewares(web)
         */
        if (! ($file && $file->isOwn())) {
            return response(['message' => 'چنین فایلی وجود ندارد.']);
        }
        FileRepo::delete($file);

        return response(['message' => 'با موفقیت حذف شد.']);
    }

    private function createFile(UploadRequest $request)
    {
        $filePath = $request->file('file')->store('files/' . jalalyFolder());

        return FileRepo::create($request->file('file')->getClientOriginalName(), $filePath);
    }

    private function saveMp3($base64)
    {
        $path = 'voices/' . auth()->id();
        $name = Str::random(15) . '.mp3';
        $base64 = Str::of($base64)->after('data:audio/mp3;base64,');
        $audio = base64_decode($base64, true);

        file_put_contents("temp/{$name}", $audio);

        FileFacade::ensureDirectoryExists(storage_path("app/{$path}"));

        FileFacade::move(public_path("temp\\{$name}"), storage_path("app/{$path}/{$name}"));

        return FileRepo::create($name, "{$path}/{$name}");
    }
}
