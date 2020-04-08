<?php

namespace Admin\Http\Controllers;

use App\Models\Event;
use Illuminate\Routing\Controller;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return view('Admin::event',compact('events'));
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return back();
    }
}