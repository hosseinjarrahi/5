<?php

namespace App\Http\Controllers;

use App\Quiz;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::orderByDesc('id')->paginate(10);
        return view('admin.home',compact('quizzes'));
    }
}
