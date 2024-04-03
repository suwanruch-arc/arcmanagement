<?php

namespace App\Http\Livewire\Layouts;

use Livewire\Component;

class SidebarMenu extends Component
{
    public $menu;
    public $children;

    public function render()
    {
        return view('livewire.layouts.sidebar-menu');
    }
}
