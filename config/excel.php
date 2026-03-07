<?php

return [
    'temporary_files' => [
        'local_path' => env('EXCEL_TEMP_PATH', storage_path('framework/cache/laravel-excel')),
        'local_permissions' => [
            'dir' => 0777,
            'file' => 0666,
        ],
        'remote_disk' => null,
        'remote_prefix' => null,
        'force_resync_remote' => null,
    ],
];
