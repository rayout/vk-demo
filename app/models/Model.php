<?php

namespace App\models;


use Core\SingletonTrait;

abstract class Model
{
    use SingletonTrait;

    protected $connection;
    protected $table;
    protected $db;


    public function __construct()
    {
        if(empty($this->connection)){
            throw new \Exception('Установите connection');
        }

        if(empty($this->table)){
            throw new \Exception('Установите table');
        }

        $this->db = db($this->connection);
    }
}