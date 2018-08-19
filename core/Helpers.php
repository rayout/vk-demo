<?php

function app()
{
    return \Core\ServiceContainer::getInstance();
}

function config()
{
    return app()
        ->set('config', '\Core\Config')
        ->buildClass('config');
}

function dd()
{
    $args = func_get_args();
    call_user_func_array('var_dump', $args);
    die();
}
