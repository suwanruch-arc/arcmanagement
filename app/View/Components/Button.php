<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Button extends Component
{
    public $onclick;
    public $type;
    public $size;
    public $color;
    public $label;
    public $href;
    public $class;
    public $style;
    public $icon;
    public $iconPosition;
    public $iconSize;
    public $tooltip;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($onclick = null, $tooltip = '', $size = null, $color = null, $type = 'button', $label = null, $href = '#', $class = null, $style = '', $icon = '', $iconPosition = 'prepend', $iconSize = '24')
    {
        $arr_class = [
            $color ? "btn-{$color}" : '',
            $size ? "btn-{$size}" : '',
        ];
        $string_class = implode(' ', $arr_class);
        $this->class = "d-flex align-items-center gap-2 btn " . $string_class . " {$class}";
        $this->type = $type;
        $this->label = $label;
        $this->href = $href;
        $this->style = $style;
        $this->icon = $icon;
        $this->iconPosition = $iconPosition;
        $this->iconSize = "{$iconSize}px";
        $this->tooltip = $tooltip ? 'data-bs-toggle=tooltip data-bs-title=' . $tooltip : '';
        $this->onclick = $onclick ? "onclick={$onclick}" : '';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.button');
    }
}
