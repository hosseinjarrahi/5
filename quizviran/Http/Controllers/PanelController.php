<?php

namespace Quizviran\Http\Controllers;

use App\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;

class PanelController extends Controller
{
    public function home()
    {
        /** 
         * @get('/quiz/panel/rooms')
         * @name('')
         * @middlewares(web, auth)
         */
        $rooms = auth()->user()->rooms;
        return view('Quizviran::panel.teacher.home',compact('rooms'));
    }

}