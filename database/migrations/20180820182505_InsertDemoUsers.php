<?php

use Phpmig\Migration\Migration;

class InsertDemoUsers extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $password = password_hash(123, PASSWORD_DEFAULT);
        $sql = /** @lang MySQL */
            "INSERT INTO users (email, password, balance) VALUES ('user1@test.ru', '$password', 1000);
INSERT INTO users (email, password, balance) VALUES ('user2@test.ru', '$password', 1000);";
        $container = $this->getContainer();
        $container['db']->query($sql);
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $sql = "delete from users where email = 'user1@test.ru'; delete from users where email = 'user2@test.ru';";
        $container = $this->getContainer();
        $container['db']->query($sql);
    }
}