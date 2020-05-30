<?php

namespace Quizviran\Http\Controllers;

use Illuminate\Routing\Controller;

class PanelController extends Controller
{
    public function home()
    {
        /**
         * @get('/quiz/panel/rooms')
         * @name('quizviran.rooms')
         * @middlewares(web, auth)
         */
        $rooms = auth()->user()->rooms;
        return view('Quizviran::panel.teacher.home',compact('rooms'));
    }

}
