<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Form extends Component
{
    public $attributes;
    public function __construct($attributes = null)
    {
        $this->attributes = $attributes;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.form');
    }
}
