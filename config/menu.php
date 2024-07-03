<?php

return [
    [
        'label' => 'Menus',
        'id' => 'menus',
        'children' => [
            [
                'label' => 'แดชบอร์ด',
                'id' => 'dashboard',
                'icon' => 'dashboard',
                'url' => '/',
            ],
            [
                'label' => 'แคมเปญ',
                'id' => 'campaign',
                'icon' => 'campaign',
                'url' => '/site/campaigns/'
            ],
            [
                'label' => 'E-Code',
                'id' => 'ecode',
                'icon' => 'qr_code',
                'url' => '/site/ecode/'
            ],
            [
                'label' => 'รายงาน',
                'id' => 'report',
                'icon' => 'pie_chart',
                'url' => '/manage/reports/',
            ]
        ],
    ],
    [
        'label' => 'Managements',
        'id' => 'management',
        'children' => [
            [
                'label' => 'ร้านค้า',
                'id' => 'shop',
                'icon' => 'store',
                'url' => '/manage/shops'
            ],
            [
                'label' => 'Partner / Department',
                'id' => 'partner',
                'icon' => 'handshake',
                'url' => '/manage/partners/'
            ],
            [
                'label' => 'ผู้ใช้งาน',
                'id' => 'user',
                'icon' => 'person',
                'url' => '/manage/users'
            ],
            [
                'label' => 'จัดการสิทธิ์',
                'id' => 'permission',
                'icon' => 'format_list_bulleted',
                'url' => '/manage/permissions'
            ],
            [
                'label' => 'รายการเส้นทาง',
                'id' => 'route',
                'icon' => 'route',
                'url' => '/manage/routes'
            ]
        ]
    ],
    [
        'label' => 'Account',
        'children' => [
            [
                'label' => 'เปลี่ยนรหัสผ่าน',
                'id' => 'change_password',
                'icon' => 'password',
                'url' => '/account/change-password'
            ]
        ]
    ]
];