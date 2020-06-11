<?php

namespace Admin\ComponentControllers;

use Illuminate\View\Component;

class TopNavigation extends Component
{
    public function __construct()
    {
    }

    public function render()
    {
        return view('Admin::components.topNavigation');
    }
}
