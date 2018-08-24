<?php

namespace App\models;


class RoleModel extends Model
{
    protected  $table = 'role';
    protected  $connection = 'db2';

    public function getById($id)
    {
        return $this->db->cell("select name from {$this->table} where id = ?", $id);
    }
}