<?php

namespace App\View\Components;

use App\Models\Partner;
use Illuminate\View\Component;

class AssignList extends Component
{
    public $selected;
    public $required;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($selected = [], $required = false)
    {
        $this->selected = $selected;
        $this->required = $required;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $partners = Partner::all();
        return view('components.assign-list', [
            'partners' => $partners
        ]);
    }
}
