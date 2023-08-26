<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ActionBtn extends Component
{
    public $route;
    public $params;
    public $disable;

    public function __construct($disable = null, $route, $params = [])
    {
        $this->route = $route;
        $this->params = $params;
        $this->disable = $disable;
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
