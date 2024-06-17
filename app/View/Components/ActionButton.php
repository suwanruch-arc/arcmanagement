<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ActionButton extends Component
{
    public $route;
    public $params;
    public $id;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $route, $params = [])
    {
        $this->id = $id;
        $this->route = $route;
        $this->params = $params;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.action-button');
    }
}
