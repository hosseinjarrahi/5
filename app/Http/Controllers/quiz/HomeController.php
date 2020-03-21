<?php

namespace App\Http\Controllers\quiz;

use App\Models\Quiz\Quiz;
use App\Http\Resources\QuizResourse;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
//        $quizzes = $this->getShowableQuizzes();
//        $quizzes = QuizResourse::collection($quizzes)->toJson();

        return view('home');
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
