<?php

namespace Quizviran\Http\Controllers;

use App\Models\User;
use Quizviran\Models\Quiz;
use Quizviran\Models\Room;
use Quizviran\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Quizviran\Http\Resources\QuizResourse;

class RoomController extends Controller
{
    public function create()
    {
        return view('Quizviran::panel.teacher.roomCreate');
    }

    public function show($room)
    {
        $room = Room::where('link',$room)->with(['members.count','comments'])->firstOrFail();
        $quizzes = QuizResourse::collection($room->quizzes);
        return view('Quizviran::panel.teacher.room', compact('room','quizzes'));
    }

    public function store()
    {
        $request = request();

        $room1 = true;
        while ($room1 || $room2) {
            $link = \Str::random(10);
            $code = random_int(100000, 999999);
            $room1 = Room::where('link', $link)->first();
            $room2 = Room::where('code', $code)->first();
        }

        $room = Room::create([
            'name' => $request->name,
            'link' => $link,
            'user_id' => auth()->id(),
            'code' => $code,
        ]);

        return view('Quizviran::panel.teacher.roomCreated', compact('room'));
    }
}
