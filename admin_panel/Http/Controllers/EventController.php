<?php

namespace Admin\Http\Controllers;

use App\Models\Event;
use Morilog\Jalali\Jalalian;
use Illuminate\Routing\Controller;

class EventController extends Controller
{
    public function index()
    {
        /** 
         * @get('/manager/event')
         * @name('admin.event.index')
         * @middlewares(web, auth, admin)
         */
        $events = Event::all();
        return view('Admin::event',compact('events'));
    }

    public function destroy(Event $event)
    {
        /** 
         * @delete('/manager/event/{event}')
         * @name('admin.event.destroy')
         * @middlewares(web, auth, admin)
         */
        $event->delete();
        return back();
    }

    public function store()
    {
        /** 
         * @post('/manager/event')
         * @name('admin.event.store')
         * @middlewares(web, auth, admin)
         */
        $request = request();
        Event::create([
            'type' => $request->type,
            'start' => Jalalian::fromFormat('Y/m/d h:i',$request->start)->toCarbon(),
            'end' => Jalalian::fromFormat('Y/m/d h:i',$request->end)->toCarbon(),
            'body' => $request->body,
        ]);

        return back();
    }
}