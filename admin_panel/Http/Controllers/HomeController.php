<?php

namespace Admin\Http\Controllers;

use Illuminate\Routing\Controller;

class HomeController extends Controller
{
    public function __construct()
    {
    }

    public function home()
    {
        return 'home';
    }
}