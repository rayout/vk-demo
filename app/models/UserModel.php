<?php

namespace App\models;


class UserModel extends Model
{
    protected  $table = 'users';
    protected  $connection = 'db1';

    public function attempt($email, $password)
    {
        $user = $this->db->row("select * from {$this->table} where email = ?",$email);
        if(password_verify($password,$user['password'])){
            unset($user['password']);
            return $user;
        }
        return false;
    }

    public static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}