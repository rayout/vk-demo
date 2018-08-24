<?php
namespace Core;

trait SingletonTrait{

    /**
     * @author Alex <alex_sh@kodeks.ru>
     * @return $this
     */
    public static function getInstance()
    {
        static $instance = null;
        if ($instance === null) {
            $instance = new static();
        }
        return $instance;
    }
}