<?php

namespace App\View\Components\Input;

use Illuminate\View\Component;

class Date extends Component
{
    public $label;
    public $name;
    public $id;
    public $prepend;
    public $append;
    public $format;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label = null, $name = null, $id = null, $prepend = null, $append = null, $format = 'Y-m-d H:i:s')
    {
        $this->label = $label;
        $this->name = $name;
        $this->id = $id ?? $name;
        $this->prepend = $prepend;
        $this->append = $append;
        $this->format = $format;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.input.date', [
            'hasError' => session()->get('errors') ? session()->get('errors')->has($this->name) : false
        ]);
    }
}
