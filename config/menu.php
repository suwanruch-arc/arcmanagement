<?php

use App\Http\Controllers\ReportController;

return [
    'menus' => [
        [
            'text' => 'Dashboard',
            'url' => 'dashboard',
        ],
    ],
    'reports' => ReportController::getReportList(),
    'account' => [
        [
            'icon' => 'lock',
            'text' => 'Change Password',
            'url' => 'account/change-password'
        ]
    ],
    'management' => [
        [
            'icon' => 'file-text',
            'text' => 'Reports',
            'url' => 'manage/reports'
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
];
