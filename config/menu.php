<?php

use App\Http\Controllers\ReportController;
use App\Http\Controllers\Sites\CampaignController;

return [
    'menus' => [
        [
            'text' => 'Dashboard',
            'url' => 'dashboard',
        ],
        [
            'icon' => 'archive',
            'text' => 'Campaigns',
            'url' => 'site/campaigns',
            'child' => 'privileges',
        ],
        [
            'icon' => 'file-text',
            'text' => 'Reports',
            'url' => 'manage/reports'
        ],
    ],
    'management' => [
        [
            'icon' => 'layers',
            'text' => 'Maplink',
            'url' => 'manage/map-link'
        ],
        [
            'icon' => 'shopping-bag',
            'text' => ' Shops',
            'url' => 'manage/shops'
        ],
        [
            'icon' => 'users',
            'text' => 'Partners',
            'url' => 'manage/partners'
        ],
        [
            'icon' => 'user',
            'text' => 'Users',
            'url' => 'manage/users'
        ]
    ],
    'account' => [
        [
            'icon' => 'lock',
            'text' => 'Change Password',
            'url' => 'account/change-password'
        ]
    ],
];
