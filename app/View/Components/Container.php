<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Container extends Component
{
    public $fluid;
    public $cols;
    public $sm;
    public $md;
    public $lg;


    public function __construct($fluid = false, $cols = '12', $sm = null, $md = null, $lg = null)
    {
        $this->fluid = $fluid;
        $this->cols = $cols;
        $this->sm = $sm;
        $this->md = $md;
        $this->lg = $lg;
    }

    public function render()
    {
        return view('components.container');
    }
}
