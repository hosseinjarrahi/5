<?php

namespace Quizviran\Http\Controllers;

use App\Models\User;
use Quizviran\Models\Quiz;
use Illuminate\Support\Str;
use Illuminate\Routing\Controller;
use Quizviran\Repositories\ExamRepo;
use App\Repositories\UserRepo;
use Quizviran\Http\Resources\QuizResourse;

class HomeController extends Controller
{
    public function home()
    {
        /**
         * @get('/quiz')
         * @name('')
         * @middlewares(web, auth)
         */
        $quizzes = ExamRepo::publicShow();
        $quizzes = QuizResourse::collection($quizzes);
        $bestStudents = UserRepo::bestStudents();

        $rooms = collect([]);
        if (auth()->check()) {
            $rooms = auth()->user()->rooms;
        }

        return view('Quizviran::home', compact('quizzes', 'bestStudents', 'rooms'));
    }
}
