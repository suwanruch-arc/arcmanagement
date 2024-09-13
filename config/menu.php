<?php

return [
    [
        'label' => 'Menus',
        'id' => 'menus',
        'children' => [
            [
                'label' => 'แคมเปญ',
                'id' => 'campaign',
                'icon' => 'campaign',
                'url' => '/campaigns',
            ],
            [
                'label' => 'E-Code',
                'id' => 'ecode',
                'icon' => 'qr_code',
                'url' => '/ecode',
            ],
            [
                'label' => 'รายงาน',
                'id' => 'report',
                'icon' => 'pie_chart',
                'url' => '/reports',
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
                'url' => '/shops'
            ],
            [
                'label' => 'Partner / Department',
                'id' => 'partner',
                'icon' => 'handshake',
                'url' => '/partners'
            ],
            [
                'label' => 'ผู้ใช้งาน',
                'id' => 'user',
                'icon' => 'person',
                'url' => '/users'
            ],
            [
                'label' => 'จัดการสิทธิ์',
                'id' => 'permission',
                'icon' => 'format_list_bulleted',
                'url' => '/permissions'
            ],
            [
                'label' => 'รายการเส้นทาง',
                'id' => 'route',
                'icon' => 'route',
                'url' => '/routes'
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