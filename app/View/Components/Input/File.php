<?php

namespace App\View\Components\Input;

use Illuminate\View\Component;

class File extends Component
{
    public $label;
    public $name;
    public $id;
    public $path;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label, $name, $id = null, $path = null)
    {
        $this->label = $label;
        $this->name = $name;
        $this->id = $id ?? $name;
        $this->path = $path;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.input.file', [
            'hasError' => session()->get('errors') ? session()->get('errors')->has($this->name) : false
        ]);
    }
}
