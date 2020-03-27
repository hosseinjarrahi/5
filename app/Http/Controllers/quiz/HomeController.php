<?php

namespace App\Http\Controllers\quiz;

use App\Models\Quiz;
use App\Http\Resources\QuizResourse;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $quizzes = $this->getShowableQuizzes();
        $quizzes = QuizResourse::collection($quizzes)->toJson();

        return view('quiz.home',compact('quizzes'));
    }

    public function result(Quiz $quiz)
    {
        $user = auth()->user();
        $users = $quiz->getQuizUsersWithNorms();
        return view('quiz.results', compact('users', 'user','quiz'));
    }

    private function getShowableQuizzes()
    {
        return Quiz::where('show', '1')->orderByDesc('id')->get();
    }

}
