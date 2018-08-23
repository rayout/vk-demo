<?php

namespace App\controllers;

use Core\Request;
use Core\Response;

class MainController {

    public function index(Request $request, Response $response){
        echo 'it is works!';
    }

    public function notFound(Request $request, Response $response){
        $response->json(['error' => 'not_found'], 404);
    }
}