<?php

namespace Core;

use \Firebase\JWT\JWT;

class Auth
{

    private static $user = false;

    /**
     * Auth constructor.
     */
    public function __construct()
    {
        JWT::$leeway = 60;
    }

    public function login($login, $pass)
    {
        $key = config()->get('jwt.key');
        $payload = [
            'user' => [
                'id' => 1
            ],
            "iat" => time(),
            'nbf' => time() + 10,
            'exp' => strtotime('+1 hour')
        ];

         return JWT::encode($payload, $key);
    }

    public function loginByJWT($jwt)
    {
        $key = config()->get('jwt.key');
        $data = JWT::decode($jwt, $key, array('HS256'));
        \dd(123, $data);
    }

    /**
     * Вернуть пользователя
     * @return mixed
     */
    public function user()
    {
        return self::$user;
    }
}