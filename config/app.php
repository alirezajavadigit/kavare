<?php

return [
    'APP_TITLE' => "Kavare",
    "BASE_URL" => "http://localhost:8000",
    "BASE_DIR" => dirname(__DIR__),
    'providers' => [
        \App\Providers\SessionProivder::class,
        \App\Providers\AppServiceProvider::class,
    ]
];
