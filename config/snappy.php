<?php

return [

    'pdf' => [
        'enabled' => true,
        'binary'  => env('WKHTMLTOPDF_PATH', '/home/tadbeeralebdaaon/public_html/wkhtmltopdf/bin/wkhtmltopdf'),
        'timeout' => false,
        'options' => [
            'encoding'         => 'UTF-8',
            'dpi'              => 300,
            'print-media-type' => true,
            'no-outline'       => true,
        ],
        'env' => [],
    ],

    'image' => [
        'enabled' => true,
        'binary'  => env('WKHTMLTOIMAGE_PATH', '/home/tadbeeralebdaaon/public_html/wkhtmltopdf/bin/wkhtmltoimage'),
        'timeout' => false,
        'options' => [
            'encoding' => 'UTF-8',
        ],
        'env' => [],
    ],

];
