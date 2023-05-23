<?php

use App\Http\Controllers\ReportController;

return [
    'menus' => [
        [
            'text' => 'Dashboard',
            'url' => '/',
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
