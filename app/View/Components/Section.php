<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Section extends Component
{
    public $title;
    public $toolbar;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title = 'Section', $toolbar = null)
    {
        $this->title = $title;
        $this->toolbar = $toolbar;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.section');
    }
}
