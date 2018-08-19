<?php

namespace Core;

Class Route {
    public static $routes = [];

    /**
     * @var array
     */
    protected static $patterns = [
        '{integer}' => '([0-9]+)',
        '{string}'  => '([a-zA-Z]+)',
        '{any}'     => '([^/]+)',
    ];

    public function start()
    {
        $currentUrl = self::getCurrentUrl();

        foreach(self::$routes as $key=>$route){
            // заменяем паттерны в правиле
            $route['url'] = str_replace(array_keys(self::$patterns), array_values(self::$patterns), $route['url']);

            if(preg_match_all('#^'.$route['url'].'$#', $currentUrl, $matches, PREG_SET_ORDER)){
                unset($matches[0][0]);
                return $this->loadRoute($route, $matches[0]);
            }
        }

        echo 'WOW 404!!';
    }

    public static function get()
    {
        $arguments = func_get_args();
        static::addRoute('GET', $arguments);
    }

    public static function post()
    {
        $arguments = func_get_args();
        static::addRoute('POST', $arguments);
    }

    private function loadRoute($route, $params)
    {
        if ($route['call'] instanceof \Closure) {
            return call_user_func($route['call']);
        }
        list($class, $method) = explode('@', $route['call']);

        if ( ! class_exists($class)) {
            throw new \Exception($class . ' not found when load route ' . $route['url']);
        }

        call_user_func_array([new $class, $method], array_values($params));
    }

    public static function getCurrentUrl()
    {
        return static::normalizeUrl($_SERVER['REQUEST_URI']);
    }

    public static function getRequestMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    private static function normalizeUrl($url)
    {
        return preg_replace('#^(/?)(.*)/$#', '/$2', $url);
    }

    private static function addRoute($method, $arguments)
    {
        $collection = static::loadArgs($arguments);
        self::$routes[] = [
            'method'     => $method,
            'url'        => $collection['url'],
            'call'       => $collection['call'],
            'middleware' => $collection['middleware']
        ];
    }

    private static function loadArgs(array $arguments)
    {
        return [
          'url' => self::normalizeUrl($arguments[0]),
          'call' => $arguments[1],
          'middleware' => !empty($arguments[2])
              ? (is_array($arguments[2]) ? $arguments[2] : [$arguments[2]])
              : [],
        ];
    }

}