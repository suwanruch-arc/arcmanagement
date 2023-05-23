<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Alert extends Component
{
    public $type;
    public $dismiss;

    public function __construct($type = 'info', $dismiss = false)
    {
        $this->type = $type;
        $this->dismiss = $dismiss;
    }

    public function render()
    {
        return view('components.alert');
    }
}
