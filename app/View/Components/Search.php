<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Search extends Component
{
    public $fields;
    public function __construct($fields = [])
    {
        $this->fields = $fields;
    }

    public function render()
    {
        return view('components.search');
    }
}
