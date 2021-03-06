<?php

use Phpmig\Migration\Migration;

class AddUsersTable extends Migration
{

    public $connection = 'db1';

    /**
     * Do the migration
     */
    public function up()
    {
        $sql = /** @lang MySQL */
            <<<SQL
CREATE TABLE users
(
    id int PRIMARY KEY auto_increment,
    email varchar(128) NOT NULL,
    password varchar(128) NOT NULL,
    balance int default 0,
    balance_updated_at timestamp,
    role int
);
CREATE UNIQUE INDEX users_email_uindex ON users (email);
SQL;
        $container = $this->getContainer();
        $container[$this->connection]->query($sql);
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $sql = "drop table users;";
        $container = $this->getContainer();
        $container[$this->connection]->query($sql);
    }
}