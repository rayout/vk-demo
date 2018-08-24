<?php

use Phpmig\Migration\Migration;

class AddRoleTable extends Migration
{
    public $connection = 'db2';

    /**
     * Do the migration
     */
    public function up()
    {
        $sql = /** @lang MySQL */
            <<<SQL
CREATE TABLE role
(
    id int PRIMARY KEY,
    name varchar(128) NOT NULL
);
INSERT INTO role (id, name) VALUES (1, 'customer');
INSERT INTO role (id, name) VALUES (2, 'executor');
SQL;
        $container = $this->getContainer();
        $container[$this->connection]->query($sql);
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $sql = "drop table role;";
        $container = $this->getContainer();
        $container[$this->connection]->query($sql);
    }
}