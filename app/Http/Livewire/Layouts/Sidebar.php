<?php

namespace App\Http\Livewire\Layouts;

use Livewire\Component;

class Sidebar extends Component
{
    public function render()
    {
        return view('livewire.layouts.sidebar');
    }

    public $menus;

    public function mount()
    {
        $this->menus = [
            [
                'name' => 'Dashboard'
            ],
            [
                'name' => 'Menus',
                'children' => [
                    ['name' => 'Campaigns'],
                    ['name' => 'Reprots']
                ]
            ]
        ];
        // $this->menus = [
        //     'menus' => [
        //         [
        //             'icon' => 'dashboard',
        //             'text' => 'Dashboard',
        //             'url' => 'dashboard',
        //         ],
        //         [
        //             'icon' => 'campaign',
        //             'text' => 'Campaigns',
        //             'url' => 'site/campaigns',
        //             'child' => 'privileges',
        //         ],
        //         [
        //             'icon' => 'pie_chart',
        //             'text' => 'Reports',
        //             'url' => 'manage/reports'
        //         ],
        //     ],
        //     'management' => [
        //         [
        //             'icon' => 'handyman',
        //             'text' => 'เครื่องมือสร้างข้อมูล',
        //             'url' => 'manage/generator'
        //         ],
        //         [
        //             'icon' => 'code',
        //             'text' => 'Maplink',
        //             'url' => 'manage/map-link'
        //         ],
        //         [
        //             'icon' => 'store',
        //             'text' => 'Shops',
        //             'url' => 'manage/shops'
        //         ],
        //         [
        //             'icon' => 'handshake',
        //             'text' => 'Partners',
        //             'url' => 'manage/partners'
        //         ],
        //         [
        //             'icon' => 'person',
        //             'text' => 'Users',
        //             'url' => 'manage/users'
        //         ]
        //     ],
        //     'account' => [
        //         [
        //             'icon' => 'lock',
        //             'text' => 'Change Password',
        //             'url' => 'account/change-password'
        //         ]
        //     ],
        // ];
    }
}
