<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Button extends Component
{
    public $size;
    public $type;
    public $href;
    public $color;
    public $tooltip;
    public $class;
    public $label;
    public $icon;
    public $prependIcon;

    public function __construct($size = null, $type = 'button', $href = '#', $color = null, $label = '', $tooltip = null, $class = null, $icon = null, $prependIcon = null)
    {
        $arr_class = [
            $color ? 'btn-' . $color : '',
            $size ? 'btn-' . $size : '',
        ];
        $string_class = implode(' ', $arr_class);
        $this->class = "d-flex align-item-center gap-2 btn " . $string_class;

        $this->type = $type;
        $this->href = $href;
        $this->tooltip = $tooltip ? 'data-bs-toggle=tooltip data-bs-placement=top data-bs-title=' . $tooltip  : '';
        $this->label = $label;
        $this->icon = $icon;
        $this->size = $size;
        $this->prependIcon = $prependIcon;
    }

    public function render()
    {
        return view('components.button');
    }
}
