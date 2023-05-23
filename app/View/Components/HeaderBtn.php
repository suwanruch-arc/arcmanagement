<?php

namespace App\View\Components;

use Illuminate\View\Component;

class HeaderBtn extends Component
{

    public $justify;
    public $buttons;

    public function __construct($justify = 'start', $buttons = [])
    {
        $this->justify = $justify;
        $this->buttons = $buttons;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.header-btn');
    }
}
