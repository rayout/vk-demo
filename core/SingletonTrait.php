<?php
namespace Core;

trait SingletonTrait{
    protected static $instance;

    /**
     * @author Alex <alex_sh@kodeks.ru>
     * @return $this
     */
    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }

        return static::$instance;
    }
}