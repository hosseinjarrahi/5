<?php

namespace Quizviran\Http\Controllers;

use App\Models\User;
use Quizviran\Models\Quiz;
use Quizviran\Models\Room;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;
use Quizviran\Http\Resources\QuizResourse;

class HomeController extends Controller
{
    public function home()
    {
        $quizzes = Quiz::public()->show()->get();
        $quizzes = QuizResourse::collection($quizzes);
        $bestStudents = User::bestStudents()->get();
        $rooms = collect([]);
        if (auth()->check()) {
            $rooms = auth()->user()->rooms;
        }
        return view('Quizviran::home', compact('quizzes', 'bestStudents', 'rooms'));
    }
}