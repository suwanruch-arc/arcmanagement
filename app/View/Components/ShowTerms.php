<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ShowTerms extends Component
{
    public $tandc;
    public $id;
    public function __construct($tandc)
    {
        $this->tandc = $tandc;
        $this->id = rand(1, 99);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.show-terms');
    }
}
