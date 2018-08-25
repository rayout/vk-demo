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
            return $this->addRole($user);
        }
        return false;
    }

    public function addRole($user)
    {
        $role_id = $user['role'];
        if($role_id > 0 ){
            $user['role'] = RoleModel::getInstance()->getById($role_id);
        }
        return $user;
    }

    public static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function getById($id)
    {
        return $this->addRole($this->db->row("Select * from {$this->table} where id = {$id}"));
    }

    public function decreaseBalance($user_id, $balance)
    {
        $this->db->update($this->table, [
            'balance' => $balance
        ], ['id' => $user_id]);

        return $balance;
    }

}