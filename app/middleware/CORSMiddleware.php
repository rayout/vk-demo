<?php

namespace App\middleware;

use Core\Middleware;


class CORSMiddleware extends Middleware {

    public function run()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

        return $this->next();
    }
}