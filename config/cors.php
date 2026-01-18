<?php

return [
    // Paths that should be processed by the CORS middleware
    'paths' => ['api/*', 'project/*', '*'],

    // Allowed HTTP methods
    'allowed_methods' => ['*'],

    // Allowed origins
    'allowed_origins' => [
        'https://anyx-project.my.id',
        'https://www.anyx-project.my.id',
    ],

    // Allow any subdomain of anyx-project.my.id (e.g., staging)
    'allowed_origins_pattern' => '/^https:\/\/(.+\.)?anyx-project\.my\.id$/',

    // Allowed request headers
    'allowed_headers' => ['*'],

    // Headers that are exposed to the browser
    'exposed_headers' => ['*'],

    // Preflight cache duration (in seconds)
    'max_age' => 86400,

    // Whether or not the response can be exposed when the credentials flag is true
    'supports_credentials' => false,
];
