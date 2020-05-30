<?php

namespace Admin\Http\Controllers;

use App\Models\Event;
use Admin\repositories\EventRepo;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        /**
         * @get('/manager/event')
         * @name('admin.event.index')
         * @middlewares(web, auth, admin)
         */
        $events = EventRepo::all();

        return view('Admin::event', compact('events'));
    }

    public function destroy(Event $event)
    {
        /**
         * @delete('/manager/event/{event}')
         * @name('admin.event.destroy')
         * @middlewares(web, auth, admin)
         */
        EventRepo::delete($event);

        return back();
    }

    public function store(Request $request)
    {
        /**
         * @post('/manager/event')
         * @name('admin.event.store')
         * @middlewares(web, auth, admin)
         */
        EventRepo::create($request->only(['type','body']));

        return back();
    }
}
