<?php

namespace Quizviran\Http\Controllers;

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
         * @name('quizviran.home')
         * @middlewares(web, auth)
         */
        $exams = ExamRepo::publicShow();
        $exams = QuizResourse::collection($exams);
        $bestStudents = UserRepo::bestStudents();

        $rooms = collect([]);
        if (auth()->check()) {
            $rooms = auth()->user()->rooms;
        }

        return view('Quizviran::home', compact('exams', 'bestStudents', 'rooms'));
    }
}
