<?php

namespace App\models;

class TransactionModel extends Model
{
    protected  $table = 'transactions';
    protected  $connection = 'db3';

    public function open($user, $price){
        return $this->insert([
            'user_id' => $user->id,
            'amount' => $price,
            'balance_from' => $user->balance,
            'balance_to' => $user->balance + $price
        ]);
    }

    public function close($id)
    {
        $this->db->update($this->table, [
            'updated_at' => date("Y-m-d H:i:s"),
            'completed' => true
        ], ['id' => $id]);
    }

}