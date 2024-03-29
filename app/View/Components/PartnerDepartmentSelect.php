<?php

namespace App\View\Components;

use App\Models\Partner;
use App\Models\Department;
use Illuminate\View\Component;

class PartnerDepartmentSelect extends Component
{
    public $partnerList;
    public $departmentList;
    public $partnerValue;
    public $departmentValue;
    public $required;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($required = null, $partnerValue = '', $departmentValue = '')
    {
        $this->partnerList = Partner::list();
        $this->departmentList = Department::list();
        $this->partnerValue = $partnerValue;
        $this->departmentValue = $departmentValue;
        $this->required = $required;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.partner-department-select');
    }
}
