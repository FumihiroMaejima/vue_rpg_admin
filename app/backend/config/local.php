<?php

return [
    'seeder' => [
        'password' => [
            'testuser' => env('TEST_USR_SEEDER_PASSWORD', 'password'),
            'testadmin' => env('TEST_ADMIN_SEEDER_PASSWORD', 'password')
        ]
    ]
];
