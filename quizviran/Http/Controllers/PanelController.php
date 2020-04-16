<?php

namespace Quizviran\Http\Controllers;

use App\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;

class PanelController extends Controller
{
    public function __construct()
    {
        if(!auth()->check())
            return abort(404);
    }

    public function home()
    {
        $rooms = auth()->user()->rooms;
        return view('Quizviran::panel.teacher.home',compact('rooms'));
    }

}