<?php

/**
 * @author Alex <alex_sh@kodeks.ru>
 * @return  \Core\ServiceContainer
 */
function app()
{

    return \Core\ServiceContainer::getInstance();
}

/**
 * @return \Core\Config
 * @throws Exception
 */
function config()
{
    return app()
        ->set('config', '\Core\Config')
        ->buildClass('config');
}

/**
 * @return \Core\Response
 * @throws Exception
 */
function route()
{
    return app()->buildClass('Route');
}

/**
 * @return \Core\Auth|bool
 */
function auth()
{
    return app()->singleton('Auth');
}

/**
 * @return \ParagonIE\EasyDB\EasyDB|bool
 */
function db($connection = 'db1')
{


    if($db = app()->singleton('db' . $connection)){
        return $db;
    }else {

        $host = config()->get("database.{$connection}.host");
        $port = config()->get("database.{$connection}.port");
        $user = config()->get("database.{$connection}.user");
        $pass = config()->get("database.{$connection}.pass");
        $database = config()->get("database.{$connection}.database");

        $db = \ParagonIE\EasyDB\Factory::create(
            "mysql:host=$host;port=$port;dbname=$database",
            $user,
            $pass
        );

        return app()
            ->setObject('db' . $connection, $db)
            ->singleton('db' . $connection);
    }
}

function dd()
{
    $args = func_get_args();
    call_user_func_array('var_dump', $args);
    die();
}
