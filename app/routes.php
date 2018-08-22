<?php

//route()::get(
//    '/', 'App\Controllers\MainController@index', [
//        App\Middleware\AuthMiddleware::class
//    ]
//);

route()::post(
    '/api/login', 'App\Controllers\AuthController@login'
);


route()::get('.*', function() {
    echo file_get_contents(__DIR__ . '/views/index.html');
});