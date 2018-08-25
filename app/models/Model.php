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
     * Грязная функция для добавления даных колонки из одного массива в другой на основе связи.
     *
     * @param $data
     * @param $column
     * @param $donor
     * @param $donor_column
     * @param $to
     * @return mixed
     */
    public function addColumn($data, $data_columns, $donor, $donor_columns)
    {
        $donor = array_reduce($donor, function($result, $item)use ($donor_columns){
            $result[$item[key($donor_columns)]] = $item[reset($donor_columns)];
            return $result;
        });

        $data = array_map(function($value) use ($donor, $data_columns){
            $value[key($data_columns)] = $donor[$value[reset($data_columns)]];
            return $value;
        }, $data);

        return $data;
    }
}