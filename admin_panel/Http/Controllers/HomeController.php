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
}
