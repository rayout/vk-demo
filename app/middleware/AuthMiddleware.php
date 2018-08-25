<?php

namespace App\middleware;

use App\models\UserModel;
use Core\Middleware;


class AuthMiddleware extends Middleware {

    public function run()
    {
        $jwt = $this->request->getAuth();
        if(!$jwt){
            return $this->response->json(['success' => 'false', 'error' => 'Необходима авторизация']);
        }
        $decoded = auth()->decodeJWT($jwt);
        if(!empty($decoded->user)) {
            $user = UserModel::getInstance()->getById($decoded->user->id);
            auth()->setUser((object) $user);
        }

        return $this->next();
    }
}