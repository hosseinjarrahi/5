<?php

namespace Quizviran\Http\Controllers;

use App\Models\User;
use Quizviran\Models\Room;
use Illuminate\Routing\Controller;

class StudentController extends Controller
{
    public function join()
    {
        if (! auth()->check()) {
            return abort(404);
        }

        return view('Quizviran::panel.student.join');
    }


    public function addStudent()
    {
        if (! auth()->check()) {
            return abort(404);
        }

        $request = request();
        $room = Room::where('lock',false)->where('code',$request->code)->first();
        if(!$room)
            return back();
        auth()->user()->rooms()->save($room);
        return redirect(url('/quiz/panel/room',['room' => $room->link]));
    }
}