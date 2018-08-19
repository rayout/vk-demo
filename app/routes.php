<?php

route()::get(
    '/', 'App\Controllers\MainController@index', [
    'middleware' => [
        'auth'
    ],
]);