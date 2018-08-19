<?php

namespace Core;

class ServiceContainer
{
    /**
     * @var array
     *
     * все классы
     */
    protected $bindings = [];

    /**
     * @var ServiceContainer
     */
    private static $instance;

    /**
     * @return ServiceContainer
     */
    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    /**
     * @param $key
     * @param $object
     *
     * @return $this
     */
    public function set($key, $object)
    {
        $this->bindings[$key] = compact('object');

        return $this;
    }

    /**
     * @param $key
     *
     * @param $params
     *
     * @return mixed
     * @throws \Exception
     */
    public function buildClass($key, $params = null)
    {
        if (!array_key_exists($key, $this->bindings)) {
            throw new \Exception("`Class $key not found`...");
        }

        return $this->instance($this->bindings[$key]['object'], $params);
    }

    /**
     * @param array $classes
     *
     * @return mixed
     */
    public function loadClasses(array $classes)
    {
        foreach ($classes as $k) {
            $name = explode('\\', $k);
            $this->set(end($name), $k)->instance($k);
        }
    }

    /**
     * @param $key
     * @param $parameters
     *
     * @return mixed
     */
    private function instance($key, $parameters = null)
    {
        if ($key instanceof \Closure) {
            return call_user_func_array($key, $parameters);
        }

        if ( ! class_exists($key)) {
            return false;
        }

        if (substr($key, 0, 1) !== '\\') {
            $key = '\\'.$key;
        }

        if ( ! is_null($parameters)) {
            $reflection = new \ReflectionClass($key);

            return $reflection->newInstanceArgs($parameters);
        } else {
            return new $key;
        }
    }
}
        