<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Partner;

class AssignLists extends Component
{
    public $selected;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($selected = null)
    {
        $this->selected = $selected;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.assign-lists', [
            'partners' => Partner::all()
        ]);
    }
}
