<?php

namespace Admin\ComponentControllers;

use Illuminate\View\Component;

class Card extends Component
{
    public $title;

    public $color;

    public $tool;

    public function __construct($title = '',$color = 'primary',$tool = false)
    {
        $this->title = $title;
        $this->color = $color;
        $this->tool = $tool;
    }

    public function render()
    {
        return view('Admin::components.card');
    }
}
