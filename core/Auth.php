<?php

namespace Core;

use \Firebase\JWT\JWT;

class Auth
{

    private $user = false;

    /**
     * Auth constructor.
     */
    public function __construct()
    {
        JWT::$leeway = 60;
    }

    public function encodeJwt($user)
    {
        $key = config()->get('jwt.key');
        $payload = [
            'user' => $user,
            "iat" => time(),
            'nbf' => time() + 10,
            'exp' => strtotime('+1 hour')
        ];

         return JWT::encode($payload, $key);
    }

    public function decodeJWT($jwt)
    {
        $key = config()->get('jwt.key');
        return JWT::decode($jwt, $key, array('HS256'));
    }

    public function setUser($user){
        $this->user = $user;
    }

    /**
     * Вернуть пользователя
     * @return mixed
     */
    public function user()
    {
        return $this->user;
    }

    public function exists()
    {
        return !empty($this->user);
    }
}