<?php

namespace Quizviran\Http\Controllers;

use App\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    public function home()
    {
        return view('Quizviran::home');
    }
}