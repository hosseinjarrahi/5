<?php

namespace Quizviran\Http\Controllers;

use App\Models\User;
use Quizviran\Models\Room;
use Illuminate\Routing\Controller;
use Quizviran\Repositories\RoomRepo;

class StudentController extends Controller
{
    public function join()
    {
        /** 
         * @get('/quiz/panel/join-room')
         * @name('quizviran.room.join.page')
         * @middlewares(web, auth)
         */
        return view('Quizviran::panel.student.join');
    }

    public function addStudent()
    {
        /** 
         * @post('/quiz/panel/join-room')
         * @name('quizviran.room.join')
         * @middlewares(web, auth)
         */
        $request = request();

        $room = RoomRepo::findOpenedRoomWithCode($request->code);

        if (! $room) {
            return back()->with(['message' => 'کلاس مورد یافت نشد و یا قفل شده است.']);
        }

        if (! auth()->user()->hasRoom($room)) {
            auth()->user()->rooms()->save($room);
        }

        return redirect(url('/quiz/panel/room', ['room' => $room->link]));
    }
}