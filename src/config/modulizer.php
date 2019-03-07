<?php

return [
    'namespace' => env('MODULIZER_NAMESPACE', 'Modules\\'),
    'modules_path' => env('MODULIZER_MODULES_PATH', 'Modules'),
    'default_folders' => [
        [
            'Http' => [
                'Controllers',
                'Requests',
                'Routes',
            ],
        ],
        'Models',
        'Exceptions',
        [
            'database' => [
                'migrations',
                'factories',
            ],
        ],
        [
            'resources' => [
                'lang' => [
                    'en',
                ],
            ],
        ],
    ],
];
