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

    /**
     * Запуск роутинга
     *
     * @return mixed
     * @throws \Exception
     */
    public function start()
    {
        $currentUrl = self::getCurrentUrl();

        foreach(self::$routes as $key=>$route){
            // заменяем паттерны в правиле
            $route['url'] = str_replace(array_keys(self::$patterns), array_values(self::$patterns), $route['url']);

            if($route['method'] == self::getRequestMethod()
                && preg_match_all('#^'.$route['url'].'$#', $currentUrl, $matches, PREG_SET_ORDER)){
                unset($matches[0][0]);
                return $this->loadRoute($route, $matches[0]);
            }
        }

        echo 'WOW 404!!';
    }

    /**
     * Добавление роута GET
     */
    public static function get()
    {
        $arguments = func_get_args();
        static::addRoute('GET', $arguments);
    }

    /**
     * Добавление роута POST
     */
    public static function post()
    {
        $arguments = func_get_args();
        static::addRoute('POST', $arguments);
    }

    /**
     * Запуск роута на исполнение
     *
     * @param $route
     * @param $params
     * @return mixed
     * @throws \Exception
     */
    private function loadRoute($route, $params)
    {
        if ($route['call'] instanceof \Closure) {
            return call_user_func($route['call']);
        }
        list($class, $method) = explode('@', $route['call']);

        if ( ! class_exists($class)) {
            throw new \Exception($class . ' not found when load route ' . $route['url']);
        }

        $next = [new Request(), new Response()];
        if(!empty($route['middleware'])){
            foreach($route['middleware'] as $middleware) {
                $middleware = new $middleware(...$next);
                $next = $middleware->run();
            }
        }

        call_user_func_array([new $class, $method], array_values(array_merge($next, $params)));
    }

    /**
     * @return null|string|string[]
     */
    public static function getCurrentUrl()
    {
        return static::normalizeUrl($_SERVER['REQUEST_URI']);
    }

    /**
     * @return mixed
     */
    public static function getRequestMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Убтирает последний слэш и добавляет первый
     *
     * @param $url
     * @return null|string|string[]
     */
    private static function normalizeUrl($url)
    {
        return preg_replace('#^(/?)(.*)/$#', '/$2', $url);
    }

    /**
     * @param $method
     * @param $arguments
     */
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

    /**
     * @param array $arguments
     * @return array
     */
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