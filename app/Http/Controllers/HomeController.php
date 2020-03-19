<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuizResourse;
use App\Quiz;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $quizzes = $this->getShowableQuizzes();
        $quizzes = QuizResourse::collection($quizzes)->toJson();

        return view('home', compact('quizzes'));
    }

    public function result(Quiz $quiz)
    {
        $user = auth()->user();
        $users = $quiz->getQuizUsersWithNorms();
        return view('results', compact('users', 'user','quiz'));
    }

    private function getShowableQuizzes()
    {
        return Quiz::where('show', '1')->orderByDesc('id')->get();
    }

}
