<?php

namespace PrestaC\App;

class Router
{
    private static array $routes = [];

    public static function add(
        string $method,
        string $path,
        string $controller,
        string $function,
        array $dependencies = [],
        array $middleware = [],
    ): void {
        self::$routes[] = [
            'method' => $method,
            'path' => $path,
            'controller' => $controller,
            'dependencies' => $dependencies,
            'function' => $function,
            'middleware' => $middleware
        ];
    }

    public static function run(): void
    {
        $path = '/';
        if (isset($_SERVER['REQUEST_URI'])) {
            $path = $_SERVER['REQUEST_URI'];
        }

        $method = $_SERVER['REQUEST_METHOD'];

        foreach (self::$routes as $route) {
            $pattern = "#^" . $route['path'] . "$#";
            if (preg_match($pattern, $path, $variables) && $method == $route['method']) {

                // call middleware  
                foreach ($route['middleware'] as $middleware) {
                    $instance = new $middleware;
                    $instance->before();
                }

                $function = $route['function'];
                $controller = new $route['controller']($route['dependencies']);
                call_user_func_array([$controller, $function], $variables);
            }
        }
    }
}
