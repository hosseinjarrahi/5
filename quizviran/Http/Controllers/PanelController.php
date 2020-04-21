<?php

namespace Quizviran\Http\Controllers;

use App\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;

class PanelController extends Controller
{
    public function home()
    {
        if(!auth()->check())
            return abort(401);

        $rooms = auth()->user()->rooms;
        return view('Quizviran::panel.teacher.home',compact('rooms'));
    }

}