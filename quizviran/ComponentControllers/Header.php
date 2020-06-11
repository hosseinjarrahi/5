<?php

namespace Quizviran\ComponentControllers;

use Illuminate\View\Component;

class Header extends Component
{
    public $notificationCount;

    public function __construct($notificationCount = 0)
    {
        [
            $this->notificationCount,
        ] = $this->cache();
    }

    public function render()
    {
        return view('Quizviran::components.header');
    }

    private function cache()
    {
        $count = cache()->remember('notification_count', 30, function () {
            return cache('user') ? auth()->user()->unReadNotifications()->count() : 0;
        });

        return [
            $count,
        ];
    }
}
