<?php

return [
    'create_user' => env('CREATE_USER', ''),
    'key' => env('CYT_KEY', ''),
    'supplier_identity' => env('SUPPLIER_IDENTITY', ''),
    'service_url' => env('SERVICE_URL', 'http://www.jingqu.cn/service/distributor.do'),
    'hook' => [
        'prefix' => env('CYT_HOOK_PREFIX', 'api'),
        'middleware' => env('CYT_HOOK_MIDDLEWARE', 'api'),
        'url' => env('CYT_HOOK_URL', 'cyt-hook'),
        'action' => env('CYT_HOOK_ACTION', '\Dezsidog\LaraCyt\Http\HookController')
    ]
];