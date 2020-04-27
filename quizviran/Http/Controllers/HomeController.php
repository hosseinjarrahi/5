<?php

namespace Quizviran\Http\Controllers;

use App\Models\User;
use Quizviran\Models\Quiz;
use Illuminate\Routing\Controller;
use Quizviran\Repositories\ExamRepo;
use App\Repositories\UserRepo;
use Quizviran\Http\Resources\QuizResourse;

class HomeController extends Controller
{
    public function home()
    {
        $quizzes = ExamRepo::publicShow();
        $quizzes = QuizResourse::collection($quizzes);
        $bestStudents = UserRepo::bestStudents();

        $rooms = collect([]);
        if (auth()->check()) {
            $rooms = auth()->user()->rooms;
        }
        return view('Quizviran::home', compact('quizzes', 'bestStudents', 'rooms'));
    }


    public function asset($folder, $file)
    {
        $path = app_path("../quizviran/public/$folder/$file");

        if (! \File::exists($path)) {
            return response()->json(['not found'], 404);
        }
        if (\File::extension($path) == 'css') {
            return response()->file($path, ['Content-Type' => 'text/css']);
        }
        if (\File::extension($path) == 'svg') {
            return response()->file($path, ['Content-Type' => 'image/svg+xml']);
        }

        return response()->download($path, "$file");
    }
}