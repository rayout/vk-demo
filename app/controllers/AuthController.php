<?php

namespace App\Controllers;

use Core\Request;
use Core\Response;

class AuthController {

    public function login(Request $request, Response $response){
        $login = $request->get('login');
        $pass = $request->get('pass');

        if($jwt = auth()->login($login, $pass)){
            $response->json(['success' => true, 'jwt' => $jwt]);
        }else{
            $response->json(['success' => false], 404);
        }
    }
}