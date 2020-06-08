<?php

namespace Admin\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Routing\Controller;

class HomeController extends Controller
{
    public function dashboard()
    {
        /**
         * @get('/manager')
         * @name('admin.home')
         * @middlewares(web, auth, admin)
         */
        return view('Admin::home');
    }

    public function asset($path)
    {
        $path = base_path("admin_panel/public/{$path}");

        if (! \File::exists($path)) {
            return response()->json(['not found'], 404);
        }
        if (\File::extension($path) == 'png') {
            return response()->file($path, ['Content-Type' => 'image/png']);
        }
        if (\File::extension($path) == 'css') {
            return response()->file($path, ['Content-Type' => 'text/css']);
        }
        if (\File::extension($path) == 'svg') {
            return response()->file($path, ['Content-Type' => 'image/svg+xml']);
        }


        return response()->download($path);
    }
}
