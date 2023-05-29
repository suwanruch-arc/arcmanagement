<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Route;

class Datatable extends Component
{
    public $sort;

    public function __construct($sort = false)
    {
        $this->sort = $sort ? 'true' : 'false';
    }

    public function render()
    {
        return view('components.datatable');
    }
}
