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


function dd()
{
    $args = func_get_args();
    call_user_func_array('var_dump', $args);
    die();
}
