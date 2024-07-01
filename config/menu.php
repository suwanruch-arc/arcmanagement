<?php

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
                'url' => '/site/campaigns/'
            ],
            [
                'icon' => 'qr_code',
                'label' => 'E-Code',
                'url' => '/site/ecode/'
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
                'icon' => 'store',
                'label' => 'ร้านค้า',
                'url' => '/manage/shops'
            ],
            [
                'icon' => 'handshake',
                'label' => 'Partner / Department',
                'url' => '/manage/partners/'
            ],
            [
                'icon' => 'person',
                'label' => 'ผู้ใช้งาน',
                'url' => '/manage/users'
            ],
            [
                'icon' => 'format_list_bulleted',
                'label' => 'จัดการสิทธิ์',
                'url' => '/manage/menus'
            ],
            [
                'icon' => 'route',
                'label' => 'รายการเส้นทาง',
                'url' => '/manage/routes'
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