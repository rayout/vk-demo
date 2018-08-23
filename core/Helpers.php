<?php

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
 * @return \Core\Auth
 * @throws Exception
 */
function auth()
{
    return app()->singleton('Auth');
}

/**
 * @return \ParagonIE\EasyDB\EasyDB
 * @throws Exception
 */
function db()
{
    $host = config()->get('database.host');
    $port = config()->get('database.port');
    $user = config()->get('database.user');
    $pass = config()->get('database.pass');
    $database = config()->get('database.database');

    $db = \ParagonIE\EasyDB\Factory::create(
        "mysql:host=$host;port=$port;dbname=$database",
        $user,
        $pass
    );

    return app()
        ->setObject('db', $db)
        ->singleton('db');
}

function dd()
{
    $args = func_get_args();
    call_user_func_array('var_dump', $args);
    die();
}
