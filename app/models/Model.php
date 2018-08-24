<?php

namespace App\models;


use Core\SingletonTrait;

abstract class Model
{
    use SingletonTrait;

    protected $connection;
    protected $table;
    /**
     * @var bool|\ParagonIE\EasyDB\EasyDB
     */
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

    public function run($statement, ...$params)
    {
        return $this->db->run($statement, ...$params);
    }

    public function getColumn($data, $column_name)
    {
        $result = [];
        foreach($data as $value){
            $result[] = $value[$column_name];
        }
        return array_unique($result);
    }

    /**
     * Грязная функция для замены даных колонки из одного массива на данные колонки из другого массива.
     *
     * @param $data
     * @param $column
     * @param $donor
     * @param $donor_column
     * @param $to
     * @return mixed
     */
    public function replaceColumn($data, $column, $donor, $donor_column, $to)
    {
        $donor_with_keys = [];
        foreach($donor as $key=>$item){
            $donor_with_keys[$item[$donor_column]] = $item[$to];
        }

        foreach($data as $key=>$item){
            $data[$key][$column] = $donor_with_keys[$item[$column]];
        }
        return $data;
    }
}