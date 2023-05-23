<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Card extends Component
{
    public $color;
    public $outline;

    public function __construct($color = null, $outline = false)
    {
        $this->color = $color;
        $this->outline = $outline;
    }

    public function render()
    {
        return view('components.card');
    }
}
