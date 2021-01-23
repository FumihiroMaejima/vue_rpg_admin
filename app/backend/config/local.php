<?php

return [
    'seeder' => [
        'password' => [
            'testuser' => env('TEST_USR_SEEDER_PASSWORD', 'password'),
            'testadmin' => env('TEST_ADMIN_SEEDER_PASSWORD', 'password')
        ],
        'authority' => [
            'rolesNameList' => ['マスター', '管理者', '開発者', '部分管理者', '一般'],
            'permissionsNameList' => ['作成', '読取', '更新', '削除', '部分作成', '部分読取', '部分更新', '部分削除'],
            'roles' => [
                (object)['key' => 1, 'name' => 'マスター'],
                (object)['key' => 2, 'name' => '管理者'],
                (object)['key' => 3, 'name' => '開発者'],
                (object)['key' => 4, 'name' => '部分管理者'],
                (object)['key' => 5, 'name' => '一般']
            ],
            'permissions' => [
                (object)['key' => 1, 'name' => '作成'],
                (object)['key' => 2, 'name' => '読取'],
                (object)['key' => 3, 'name' => '更新'],
                (object)['key' => 4, 'name' => '削除'],
                (object)['key' => 5, 'name' => '部分作成'],
                (object)['key' => 6, 'name' => '部分読取'],
                (object)['key' => 7, 'name' => '部分更新'],
                (object)['key' => 8, 'name' => '部分削除']
            ]
        ]
    ]
];
