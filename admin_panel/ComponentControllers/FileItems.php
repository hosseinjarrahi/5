<?php

namespace Admin\ComponentControllers;

use Illuminate\View\Component;

class FileItems extends Component
{
    public function __construct()
    {
    }

    public function render()
    {
        return view('Admin::components.fileItems');
    }
}
