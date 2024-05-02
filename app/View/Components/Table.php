<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class Table extends Component
{
    public $btn;
    public $columns;
    public $edit;
    public $delete;
    public $path;
    public $label;

    public function __construct($label = null, $columns = [], $edit = null, $delete = null, $btn = null)
    {
        $this->btn = $btn;
        $this->label = $label;
        $this->columns = $columns;
        $this->edit = $edit;
        $this->delete = $delete;
        $this->path = Route::getFacadeRoot()->current()->uri();
    }

    public function render()
    {
        return view('components.table');
    }
}
