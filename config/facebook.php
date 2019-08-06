<?php

return [
    'config' => [
        'app_id' => env('FACEBOOK_APP_ID', null),
        'app_secret' => env('FACEBOOK_APP_SECRET', null),
        'default_graph_version' => env('FACEBOOK_DEFAULT_GRAPH_VERSION', 'v2.8'),
        //'default_access_token' => env('FACEBOOK_DEFAULT_ACCESS_TOKEN')
    ],

    'page_id' => env('FACEBOOK_PAGE_ID'),
];
