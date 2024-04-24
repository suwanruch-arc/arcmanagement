<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Button extends Component
{
    public $type;
    public $href;
    public $color;
    public $tooltip;
    public $class;
    public $label;
    public $icon;
    
    public function __construct($type = 'button', $href = '#', $color = 'primary', $label = '', $tooltip = null, $class = '', $icon = null)
    {
        $this->type = $type;
        $this->href = $href;
        $this->color = $color;
        $this->tooltip = $tooltip;
        $this->label = $label;
        $this->class = $class;
        $this->icon = $icon;
    }

    public function render()
    {
        return view('components.button');
    }
}
