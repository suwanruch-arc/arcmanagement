<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Form extends Component
{
    public $model;
    public $route;
    public $params;
    public $method;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($model, $route, $params, $method = 'POST')
    {
        if (isset($model) && !empty($model)) {
            $opt_route = 'update';
            $method = 'PUT';
        } else {
            $opt_route = 'store';
        }
        $this->method = $method;
        $this->route = "{$route}.{$opt_route}";
        $this->params = $params;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form');
    }
}
