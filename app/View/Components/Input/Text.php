<?php

namespace App\View\Components\Input;

use Illuminate\View\Component;

class Text extends Component
{
    public $label;
    public $name;
    public $id;
    public $type;
    public $prepend;
    public $append;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label = null, $name = null, $id = null, $type = 'text', $prepend = null, $append = null)
    {
        $this->type = $type;
        $this->label = $label;
        $this->name = $name;
        $this->id = $id ?? $name;
        $this->prepend = $prepend;
        $this->append = $append;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.input.text', [
            'hasError' => session()->get('errors') ? session()->get('errors')->has($this->name) : false
        ]);
    }
}
