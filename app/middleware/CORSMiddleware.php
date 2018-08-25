<?php

namespace App\middleware;

use Core\Middleware;


class CORSMiddleware extends Middleware {

    public function run()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: authorization, Origin, X-Requested-With, Content-Type, Accept");
        header('Access-Control-Allow-Methods: GET,PUT,POST,DELETE,PATCH,OPTIONS');
        header('ccess-Control-Allow-Credentials: true');

        return $this->next();
    }
}