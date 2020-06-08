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

    public function asset($path)
    {
        $path = base_path("quizviran/public/{$path}");

        if (! \File::exists($path)) {
            return response()->json(['not found'], 404);
        }
        if (\File::extension($path) == 'png') {
            return response()->file($path, ['Content-Type' => 'image/png']);
        }
        if (\File::extension($path) == 'css') {
            return response()->file($path, ['Content-Type' => 'text/css']);
        }
        if (\File::extension($path) == 'svg') {
            return response()->file($path, ['Content-Type' => 'image/svg+xml']);
        }


        return response()->download($path);
    }
}
