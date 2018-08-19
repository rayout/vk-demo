<?php

route()::get(
    '/', 'App\Controllers\MainController@index', [
        App\Middleware\AuthMiddleware::class
    ]
);