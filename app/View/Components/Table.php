<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Table extends Component
{
    public $columns;

    public function __construct($columns = [])
    {
        $this->columns = $columns;
    }

    public function render()
    {
        return view('components.table');
    }
}
