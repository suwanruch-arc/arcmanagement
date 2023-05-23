<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Select extends Component
{

    public $name;
    public $label;
    public $value;
    public $required;
    public $multiple;
    public $id;
    public $src;

    public function __construct($src = [], $multiple = null, $name = '', $label = null, $value = null, $required = false, $id = null)
    {
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;
        $this->required = $required;
        $this->multiple = $multiple;
        $this->id = $id;
        $this->src = $src;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.select');
    }
}
