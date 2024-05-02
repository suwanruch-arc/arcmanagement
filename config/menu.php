<?php

use App\Http\Controllers\ReportController;
use App\Http\Controllers\Sites\CampaignController;

return [
    [
        'label' => 'Menus',
        'children' => [
            [
                'label' => 'แดชบอร์ด',
                'icon' => 'dashboard',
                'url' => '/',
            ],
            [
                'icon' => 'campaign',
                'label' => 'แคมเปญ',
                'url' => '/site/campaigns/',
                'can' => ['admin']
            ],
            [
                'icon' => 'qr_code',
                'label' => 'E-Code',
                'url' => '/site/ecode/',
                'can' => ['admin', 'moderator']
            ],
            [
                'icon' => 'pie_chart',
                'label' => 'รายงาน',
                'url' => '/manage/reports/',
            ]
        ],
    ],
    [
        'label' => 'Managements',
        'can' => ['admin'],
        'children' => [
            [
                'icon' => 'handyman',
                'label' => 'เครื่องมือสร้างข้อมูล',
                'url' => '/manage/tools/dashboard/',
                'can' => ['admin']
            ],
            [
                'icon' => 'store',
                'label' => 'ร้านค้า',
                'url' => '/manage/shops',
                'can' => ['admin']
            ],
            [
                'icon' => 'handshake',
                'label' => 'Partner / Department',
                'url' => '/manage/partners/',
                'can' => ['admin']
            ],
            [
                'icon' => 'person',
                'label' => 'ผู้ใช้งาน',
                'url' => '/manage/users',
                'can' => ['admin']
            ],
            [
                'icon' => 'format_list_bulleted',
                'label' => 'จัดการเมนู',
                'url' => '/manage/menus',
                'can' => ['admin']
            ]
        ]
    ],
    [
        'label' => 'Account',
        'children' => [
            [
                'icon' => 'password',
                'label' => 'เปลี่ยนรหัสผ่าน',
                'url' => '/account/change-password'
            ]
        ]
    ]
];
