<?php

return [
    'gemini' => [
        'url' => 'https://generativelanguage.googleapis.com/v1beta/models/:model:generateContent',
        'api_key' => env('GEMINI_API_KEY', ''),
        'models' => [
            'gemini-3.5-flash-lite',
            'gemini-3.8-flash', // has limit of 20
            'gemini-flash-latest', // fallback
        ],
    ],
];
