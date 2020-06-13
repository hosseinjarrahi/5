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
        $bestStudents = UserRepo::bestStudents();

        $rooms = collect([]);
        if (auth()->check()) {
            $rooms = cache('user')->rooms()->with('user')->get();
        }

        return view('Quizviran::home', compact('exams', 'bestStudents', 'rooms'));
    }
}
