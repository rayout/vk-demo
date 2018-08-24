<?php

namespace App\controllers;

use Core\Request;
use Core\Response;
use App\models\UserModel;

class AuthController {

    public function login(Request $request, Response $response){
        $login = $request->get('login');
        $pass = $request->get('pass');

        $user = UserModel::getInstance()->attempt($login, $pass);

        if($user){
            $jwt = auth()->encodeJwt($user);
            $response->json(['success' => true, 'jwt' => $jwt, 'user' => $user]);
        }else{
            $response->json(['success' => false], 403);
        }
    }
}