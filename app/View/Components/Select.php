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
    public $select2;

    public function __construct($src = [], $multiple = null, $name = '', $label = null, $value = null, $required = false, $select2 = false, $id = null)
    {
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;
        $this->required = $required;
        $this->multiple = $multiple;
        $this->id = $id;
        $this->src = $src;
        $this->select2 = $select2;
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
