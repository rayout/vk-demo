<?php

route()::get(
    '/', 'App\Controllers\MainController@index', [
        App\Middleware\AuthMiddleware::class
    ]
);

route()::get(
    '/login', 'App\Controllers\AuthController@login'
);