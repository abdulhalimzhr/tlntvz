<?php

require_once 'Request.php';

class Router
{
    private static $routes = [];

    public static function get($path, $controller, $action, $middleware = null)
    {
        self::addRoute('GET', $path, $controller, $action, $middleware);
    }

    public static function post($path, $controller, $action, $middleware = null)
    {
        self::addRoute('POST', $path, $controller, $action, $middleware);
    }

    public static function put($path, $controller, $action, $middleware = null)
    {
        self::addRoute('PUT', $path, $controller, $action, $middleware);
    }

    public static function delete($path, $controller, $action, $middleware = null)
    {
        self::addRoute('DELETE', $path, $controller, $action, $middleware);
    }

    public static function routes()
    {
        return self::$routes;
    }

    public static function handleRequest()
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri    = $_SERVER['REQUEST_URI'];

        foreach (self::routes() as $route) {
            if ($route['method'] === $requestMethod && $route['path'] === $requestUri) {
                $middleware = $route['middleware'] ?? null;
                if ($middleware) {
                    if (is_string($middleware)) {
                        $middlewareInstance = new $middleware();
                        if (!$middlewareInstance->handle()) {
                            header('Location: /login');
                        }
                    } elseif (is_callable($middleware)) {
                        if (!$middleware()) {
                            return;
                        }
                    }
                }

                $controllerClass =  $route['controller'];
                $controller = new $controllerClass(new Request());
                $action = $route['action'];

                if (method_exists($controller, $action)) {
                    $controller->$action();
                } else {
                    echo "Action '$action' not found in controller '$controllerClass'.";
                    return;
                }

                return;
            }
        }

        http_response_code(404);
        echo "404 - Route not found";
    }

    private static function addRoute($method, $path, $controller, $action, $middleware = null)
    {
        self::$routes[] = [
            'method' => $method,
            'path' => $path,
            'controller' => $controller,
            'action' => $action,
            'middleware' => $middleware,
        ];
    }
}
