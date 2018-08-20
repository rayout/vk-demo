<?php

use Phpmig\Migration\Migration;

class AddUsersTable extends Migration
{
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
    password varchar(128) NOT NULL
);
CREATE UNIQUE INDEX users_email_uindex ON users (email);
SQL;
        $container = $this->getContainer();
        $container['db']->query($sql);
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $sql = "drop table users;";
        $container = $this->getContainer();
        $container['db']->query($sql);
    }
}