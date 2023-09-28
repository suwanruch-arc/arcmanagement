<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Card extends Component
{
    public $class;
    public $color;
    public $outline;

    public function __construct($class = '', $color = null, $outline = false)
    {
        $this->class = $class;
        $this->color = $color;
        $this->outline = $outline;
    }

    public function render()
    {
        return view('components.card');
    }
}
