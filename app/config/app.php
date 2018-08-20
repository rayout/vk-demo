<?php

return [
    // Классы которые будут загружены при запуске приложения
    'required' => [
        \Core\Config::class,
        \Core\Route::class,
        \Core\Auth::class,
    ],
];