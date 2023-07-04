<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FileInput extends Component
{
    public $name;
    public $id;
    public $label;
    public $required;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $id = null, $label = null, $required = false)
    {
        $this->name = $name;
        $this->label = $label;
        $this->required = $required;
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.file-input');
    }
}
