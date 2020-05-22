<?php

namespace Admin\ComponentControllers;

use Illuminate\View\Component;

class MenuItem extends Component
{
    public $link;

    public $icon;

    public $active;

    public $root;

    public $label;

    public function __construct($link = '', $icon = '', $active = false,$root = false,$label = '')
    {
        $this->link = $link;
        $this->icon = $icon;
        $this->active = $active;
        $this->root = $root;
        $this->label = $label;
    }

    public function render()
    {
        return view('Admin::components.menuItem');
    }
}
