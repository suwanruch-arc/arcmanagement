<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Input extends Component
{
    public $name;
    public $label;
    public $type;
    public $value;
    public $placeholder;
    public $required;
    public $min;
    public $max;
    public $id;
    public $prepend;
    public $append;
    public $class;
    public $disabled;
    public $readonly;

    public function __construct($readonly = false, $disabled = false, $class = null, $prepend = null, $append = null, $name, $id = null, $type = 'text', $label = null, $value = null, $placeholder = null, $required = false, $min = null, $max = null)
    {
        $this->readonly = $readonly;
        $this->disabled = $disabled;
        $this->name = $name;
        $this->class = $class;
        $this->type = $type;
        $this->label = $label;
        $this->value = $value;
        $this->placeholder = $placeholder;
        $this->required = $required;
        $this->min = $min;
        $this->max = $max;
        $this->id = $id;
        $this->prepend = $prepend;
        $this->append = $append;
    }

    public function render()
    {
        return view('components.forms.input');
    }
}
