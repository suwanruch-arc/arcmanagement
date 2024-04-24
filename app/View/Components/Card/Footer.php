<?php

namespace App\View\Components\Card;

use Illuminate\View\Component;

class Footer extends Component
{
    public $class;
    public $attributes;

    public function __construct($class = null, $attributes = null)
    {
        $this->class = $class;
        $this->attributes = $attributes;
    }

    public function render()
    {
        return view('components.card.footer');
    }
}
