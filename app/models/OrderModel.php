<?php

namespace App\models;


use ParagonIE\EasyDB\EasyStatement;

class OrderModel extends Model
{
    protected  $table = 'orders';
    protected  $connection = 'db2';

    public function get($limit, $offset_id)
    {
        $orders = $this->db->run("select * from {$this->table} where id > ? and executor_user_id is null  ORDER BY id limit ?", $offset_id, $limit);
        $user_ids = $this->getColumn($orders, 'customer_user_id');

        $user_ids_statement = EasyStatement::open()->in('id in (?*)', $user_ids);
        $user_emails = UserModel::getInstance()->run("select id, email from users where {$user_ids_statement}", ...$user_ids);

        $orders = $this->replaceColumn($orders, 'customer_user_id', $user_emails, 'id', 'email');
        return $orders;
    }

    public function insert($data)
    {
        $this->db->insert($this->table, $data);
    }
}