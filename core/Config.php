<?php
namespace Core;

class Config
{

    /**
     * @param $filename
     * @return array
     * @throws \Exception
     */
    public function load($filename)
    {
        if (file_exists(dirname(__FILE__) . "/../app/config/$filename.php")) {
           return include(dirname(__FILE__) . "/../app/config/$filename.php");
        } else {
            throw new \Exception('Config ' . $filename . ' not found');
        }
    }

    /**
     * Get an item from an array using "dot" notation.
     *
     * @param $array
     * @para $key
     * @param $default
     * @return mixed
     * @throws \Exception
     */
    public function get($key, $default = null)
    {
        if(strpos($key, '.') !== false) {
            list($file, $key) = explode('.', $key, 2);
        }else{
            $file = $key;
            $key = null;
        }
        $array = $this->load($file);

        if (!$this->accessible($array)) {
            return $default;
        }

        if (is_null($key)) {
            return $array;
        }

        if (static::exists($array, $key)) {
            return $array[$key];
        }
        if (strpos($key, '.') === false) {
            return !empty($array[$key]) ? $array[$key] : value($default);
        }
        foreach (explode('.', $key) as $segment) {
            if (static::accessible($array) && static::exists($array, $segment)) {
                $array = $array[$segment];
            } else {
                return $default;
            }
        }
        return $array;
    }

    /**
     * Determine whether the given value is array accessible.
     *
     * @param  mixed  $value
     * @return bool
     */
    private function accessible($value)
    {
        return is_array($value) || $value instanceof \ArrayAccess;
    }

    /**
     * Determine if the given key exists in the provided array.
     *
     * @param  \ArrayAccess|array  $array
     * @param  string|int  $key
     * @return bool
     */
    private function exists($array, $key)
    {
        if ($array instanceof \ArrayAccess) {
            return $array->offsetExists($key);
        }
        return array_key_exists($key, $array);
    }
}