<?php

namespace Admin\ComponentControllers;

use Illuminate\View\Component;

class TopNavigation extends Component
{
    public $user;

    public function __construct()
    {
        $this->user = auth()->user();
    }

    public function render()
    {
        return view('Admin::components.topNavigation');
    }
}
