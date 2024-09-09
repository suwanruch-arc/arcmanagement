<?php

namespace App\View\Components\Input;

use Illuminate\View\Component;

class Select extends Component
{
    public $label;
    public $name;
    public $id;
    public $options;
    public $selected;
    public $placeholder;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label = null, $name, $id = null, $options = [], $selected = null, $placeholder = 'กรุณาเลือกข้อมูล')
    {
        $this->label = $label;
        $this->options = $options;
        $this->selected = $selected;
        $this->placeholder = $placeholder;
        $this->name = $name;
        $this->id = $id ?? $name;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.input.select', [
            'hasError' => session()->get('errors') ? session()->get('errors')->has($this->name) : false
        ]);
    }
}
