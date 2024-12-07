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
        array $middleware = []
    ): void {
        self::$routes[] = [
            'method' => $method,
            'path' => $path,
            'controller' => $controller,
            'function' => $function,
            'dependencies' => $dependencies,
            'middleware' => $middleware
        ];
    }

    public static function run(): void
    {
        $path = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
        $method = $_SERVER['REQUEST_METHOD'];

        // Remove trailing slash if present, unless it's just "/"
        if (strlen($path) > 1) {
            $path = rtrim($path, '/');
        }

        foreach (self::$routes as $route) {
            $pattern = "#^" . $route['path'] . "$#";
            if (preg_match($pattern, $path, $variables) && $method == $route['method']) {
                // Execute middleware
                foreach ($route['middleware'] as $middleware) {
                    $instance = new $middleware();
                    $instance->before();
                }

                $controller = new $route['controller']($route['dependencies']);
                $function = $route['function'];

                array_shift($variables);
                call_user_func([$controller, $function], $variables);
                return;
            }
        }

        http_response_code(404);
        echo "404 Not Found";
    }
}
