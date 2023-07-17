<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Button extends Component
{
    public $type;
    public $href;
    public $color;
    public $text;
    public $class;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type = 'button', $href = '#', $color = 'primary', $text = '', $class = '')
    {
        $this->type = $type;
        $this->href = $href;
        $this->color = $color;
        $this->text = $text;
        $this->class = $class;
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
