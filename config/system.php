<?php
return [
    'db_seed' => false,
    'default_role' => [
        'admin' => 'Super Admin',
    ],

    'site_title' => env('APP_NAME'),

    'boolean' => [
        'system_setting' => [
            'enable_https',
            'show_error_display',
            'enable_frontend_website',
            'ip_filter',
            'todo',
            'backup',
            'maintenance_mode',
        ],
    ],

    'default_permission' => [
        'user' => [
            'user.view' => [],
            'user.create' => [],
            'user.update' => [],
            'user.delete' => [],
        ],
        'language' => [
            'language.view' => [],
            'language.create' => [],
            'language.update' => [],
            'language.delete' => [],
        ],
        'role' => [
            'role.view' => [],
            'role.create' => [],
            'role.update' => [],
            'role.delete' => [],
        ],
        'configuration' => [
            'configuration.view' => [],
            'configuration.create' => [],
            'configuration.update' => [],
            'configuration.delete' => [],
        ],
    ],
];
?>
