<?php

namespace App\controllers;

use Core\Request;
use Core\Response;

class MainController {

    public function index(Request $request, Response $response){
        echo 'it is works!';
        dd(db()->run('select * from users'));
    }

    public function notFound(Request $request, Response $response){
        $response->json(['error' => 'not_found'], 404);
    }
}