<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CardFooter extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $class;
    public $attributes;

    public function __construct($class = null, $attributes = null)
    {
        $this->class = $class;
        $this->attributes = $attributes;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.card-footer');
    }
}
