<?php

use App\models\OrderModel;
use Phpmig\Migration\Migration;

class AddOrdersTable extends Migration
{
    public $connection = 'db2';

    /**
     * Do the migration
     */
    public function up()
    {
        $sql = /** @lang MySQL */
            <<<SQL
CREATE TABLE orders
(
    id int PRIMARY KEY auto_increment,
    title varchar(128) NOT NULL,
    description varchar(128) default NULL,
    price int,
    customer_user_id int,
    executor_user_id int,
    completed bool default false
);
SQL;
        $container = $this->getContainer();
        $container[$this->connection]->query($sql);

        $faker = Faker\Factory::create();
        for($i = 0; $i<100; $i++) {
            OrderModel::getInstance()->insert([
                'title' => $faker->sentence($nbWords = 6, $variableNbWords = true),
                'price' => $faker->numberBetween(1, 50),
                'customer_user_id' => 1
            ]);
        }
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $sql = "drop table orders;";
        $container = $this->getContainer();
        $container[$this->connection]->query($sql);
    }
}