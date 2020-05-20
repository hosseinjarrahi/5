<?php

namespace Admin\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Routing\Controller;

class HomeController extends Controller
{
    public function dashboard()
    {
        return view('Admin::index');
    }

    public function asset($path)
    {
        $path = base_path("admin_panel/public/$path");

        if (!\File::exists($path)) {
            return response()->json(['not found'], 404);
        }
        if(\File::extension($path) == 'css')
            return response()->file($path,['Content-Type'=>'text/css']);
        return response()->download($path, Str::of($path)->afterLast('/'));
    }
}
