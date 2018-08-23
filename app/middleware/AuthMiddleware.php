<?php

namespace App\middleware;

use Core\Middleware;


class AuthMiddleware extends Middleware {

    public function run()
    {
        echo 'AUTH';

        return $this->next();
    }
}