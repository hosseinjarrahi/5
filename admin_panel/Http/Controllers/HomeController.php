<?php

namespace Admin\Http\Controllers;

use Illuminate\Routing\Controller;

class HomeController extends Controller
{
    public function dashboard()
    {
        return view('Admin::index');
    }

    public function asset($folder,$file)
    {
        $path = app_path("../admin_panel/public/$folder/$file");

        if (!\File::exists($path)) {
            return response()->json(['not found'], 404);
        }
        if(\File::extension($path) == 'css')
            return response()->file($path,['Content-Type'=>'text/css']);
        return response()->download($path, "$file");
    }
}