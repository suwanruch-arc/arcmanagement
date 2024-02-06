<?php

use App\Http\Controllers\ReportController;
use App\Http\Controllers\Sites\CampaignController;

return [
    'menus' => [
        [
            'icon' => 'dashboard',
            'text' => 'Dashboard',
            'url' => 'dashboard',
        ],
        [
            'icon' => 'campaign',
            'text' => 'Campaigns',
            'url' => 'site/campaigns',
            'child' => 'privileges',
        ],
        [
            'icon' => 'pie_chart',
            'text' => 'Reports',
            'url' => 'manage/reports'
        ],
    ],
    'management' => [
        [
            'icon' => 'code',
            'text' => 'Maplink',
            'url' => 'manage/map-link'
        ],
        [
            'icon' => 'store',
            'text' => 'Shops',
            'url' => 'manage/shops'
        ],
        [
            'icon' => 'handshake',
            'text' => 'Partners',
            'url' => 'manage/partners'
        ],
        [
            'icon' => 'person',
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
