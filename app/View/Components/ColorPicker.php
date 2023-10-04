<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ColorPicker extends Component
{
    public $name;
    public $label;
    public $value;
    public $required;
    public $id;
    public $size;

    public function __construct($name = '', $label = null, $value = null, $required = false, $id = null, $size = null)
    {
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;
        $this->required = $required;
        $this->id = $id;
        $this->size = $size;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.color-picker', [
            'color_list' => [
                '#F44336' => 'red',
                '#E91E63' => 'pink',
                '#9C27B0' => 'purple',
                '#673AB7' => 'deep-purple',
                '#3F51B5' => 'indigo',
                '#2196F3' => 'blue',
                '#03A9F4' => 'light-blue',
                '#00BCD4' => 'cyan',
                '#009688' => 'teal',
                '#4CAF50' => 'green',
                '#8BC34A' => 'light-green',
                '#CDDC39' => 'lime',
                '#FFEB3B' => 'yellow',
                '#FFC107' => 'amber',
                '#FF9800' => 'orange',
                '#FF5722' => 'deep-orange',
                '#795548' => 'brown',
                '#9E9E9E' => 'grey',
                '#607D8B' => 'blue-grey',
                '#FFFFFF' => 'white',
            ]
        ]);
    }
}
