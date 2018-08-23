<?php

//route()::get(
//    '/', 'App\Controllers\MainController@index', [
//        App\Middleware\AuthMiddleware::class
//    ]
//);

route()::post(
    '/api/login', 'App\controllers\AuthController@login'
);

route()::get(
    '/test', 'App\controllers\MainController@index'
);

route()::get(
    '/api/.*', 'App\controllers\MainController@notFound'
);
route()::post(
    '/api/.*', 'App\controllers\MainController@notFound'
);



route()::get('.*', function() {
    echo file_get_contents(__DIR__ . '/views/index.html');
});