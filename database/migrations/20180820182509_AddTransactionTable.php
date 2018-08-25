<?php

use App\models\OrderModel;
use Phpmig\Migration\Migration;

class AddTransactionTable extends Migration
{
    public $connection = 'db3';

    /**
     * Do the migration
     */
    public function up()
    {
        $sql = /** @lang MySQL */
            <<<SQL
CREATE TABLE transactions
(
    id int PRIMARY KEY auto_increment,
    user_id int NOT NULL,
    amount int not null,
    balance_from int not null,
    balance_to int not null,
    completed bool default false,
    created_at timestamp default CURRENT_TIMESTAMP,
    updated_at timestamp
);
SQL;
        $container = $this->getContainer();
        $container[$this->connection]->query($sql);
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $sql = "drop table transactions;";
        $container = $this->getContainer();
        $container[$this->connection]->query($sql);
    }
}