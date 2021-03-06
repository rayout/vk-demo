<?php

namespace Core;

use App\middleware\CORSMiddleware;

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

    protected $globalMiiddleware = [
         CORSMiddleware::class
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

        $next = $this->runMiddlewaries($this->globalMiiddleware);

        foreach(self::$routes as $key=>$route){
            // заменяем паттерны в правиле
            $route['url'] = str_replace(array_keys(self::$patterns), array_values(self::$patterns), $route['url']);

            if($route['method'] == self::getRequestMethod()
                && preg_match_all('#^'.$route['url'].'$#', $currentUrl, $matches, PREG_SET_ORDER)){
                unset($matches[0][0]);
                return $this->loadRoute($route, $matches[0], $next);
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
    private function loadRoute($route, $params, $next)
    {
        if ($route['call'] instanceof \Closure) {
            return call_user_func($route['call']);
        }
        list($class, $method) = explode('@', $route['call']);

        if ( ! class_exists($class)) {
            throw new \Exception($class . ' not found when load route ' . $route['url']);
        }

       $next = $this->runMiddlewaries($route['middleware'], $next);

        call_user_func_array([new $class, $method], array_values(array_merge($next, $params)));
    }

    /**
     * @return null|string|string[]
     */
    public static function getCurrentUrl()
    {
        return static::normalizeUrl(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
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

    /**
     * @author Alex <alex_sh@kodeks.ru>
     * @param $middlewaries
     * @param bool $next
     * @return mixed
     */
    private function runMiddlewaries($middlewaries = [], $next = false)
    {
        if(!$next) {
            $next = [new Request(), new Response()];
        }
        foreach($middlewaries as $middleware) {

            $middleware = new $middleware(...$next);
            $next = $middleware->run();
        }
        return $next;
    }

}