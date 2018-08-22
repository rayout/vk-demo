<?php

namespace App\Controllers;

use Core\Request;
use Core\Response;

class AuthController {

    public function login(Request $request, Response $response){
        $login = $request->get('login');
        $pass = $request->get('pass');

        if($jwt = auth()->login($login, $pass)){
            $response->json(['success' => true, 'jwt' => $jwt, 'user' => [
                'id' => 1, 'role' => 'customer', 'name' => 'user', 'balance' => 30]
            ]);
        }else{
            $response->json(['success' => false], 403);
        }
    }
}