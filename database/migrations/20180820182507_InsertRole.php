<?php

use Phpmig\Migration\Migration;

class InsertRole extends Migration
{

    public $connection = 'db1';

    /**
     * Do the migration
     */
    public function up()
    {
        $sql = /** @lang MySQL */
            "
            UPDATE users set role = 1 WHERE email = 'user1@test.ru';
            UPDATE users set role = 2 WHERE email = 'user2@test.ru';
            ";

        $container = $this->getContainer();
        $container[$this->connection]->query($sql);
    }

    /**
     * Undo the migration
     */
    public function down()
    {

    }
}