<?php

return [

    'maps' => [
        'api_key' => env('GOOGLE_PLACES_API_KEY')
    ],

    'recaptcha' => [
        'secret' => env('RECAPTCHA_SECRET'),
        'public' => env('RECAPTCHA_PUBLIC')
    ]

];
