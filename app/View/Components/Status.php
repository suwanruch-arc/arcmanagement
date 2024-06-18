<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Status extends Component
{
    public $s;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($s)
    {
        $this->s = $s;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.status');
    }
}
