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
    '/api/orders/list', 'App\controllers\OrdersController@get'
);

route()::post(
    '/api/order/add', 'App\controllers\OrdersController@add', [\App\middleware\AuthMiddleware::class]
);

route()::get(
    '/api/.*', 'App\controllers\MainController@notFound'
);
route()::post(
    '/api/.*', 'App\controllers\MainController@notFound'
);


route()::get(
    '/test1', 'App\controllers\MainController@test1'
);
route()::get(
    '/test2', 'App\controllers\MainController@test2'
);


route()::get('.*', function() {
    echo file_get_contents(__DIR__ . '/views/index.html');
});