<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuizResourse;
use App\Quiz;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
//         $this->middleware('auth')->only('result');
    }

    public function index()
    {
        $quizzes = Quiz::where('show', '1')->orderByDesc('id')->get();
        $quizzes = QuizResourse::collection($quizzes)->toJson();

        return view('home', compact('quizzes'));
    }

    public function result(Quiz $quiz)
    {
        $user = auth()->user();
        $users = $quiz->users()->withPivot('norm')->get()->sortByDesc('pivot.norm');
        return view('results', compact('users', 'user','quiz'));
    }
}
