<?php

namespace App\Controllers;

use Core\Request;
use Core\Response;

class MainController {

    public function index(Request $request, Response $response){
        echo 'it is works!';
    }
}