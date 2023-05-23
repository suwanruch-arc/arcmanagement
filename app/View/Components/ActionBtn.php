<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ActionBtn extends Component
{
    public $route;
    public $params;

    public function __construct($route, $params = [])
    {
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
        return view('components.action-btn');
    }
}
