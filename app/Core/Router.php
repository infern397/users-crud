<?php

namespace App\Core;

use Exception;

class Router
{
    private static ?Router $instance = null;
    /** @var array<RouteDefinition[]> */
    private array $routes = [];

    private function __construct() {}
    private function __clone() {}
    public function __wakeup() {}

    public static function getInstance(): Router
    {
        if (self::$instance === null) {
            self::$instance = new Router();
        }
        return self::$instance;
    }

    public function add(string $method, string $path, callable|array $handler): RouteDefinition
    {
        $method = strtoupper($method);

        $definition = new RouteDefinition($method, $path, $handler);

        $this->routes[$method][] = $definition;

        return $definition;
    }

    public function get(string $path, callable|array $handler): RouteDefinition
    {
        return $this->add('GET', $path, $handler);
    }

    public function post(string $path, callable|array $handler): RouteDefinition
    {
        return $this->add('POST', $path, $handler);
    }

    public function put(string $path, callable|array $handler): RouteDefinition
    {
        return $this->add('PUT', $path, $handler);
    }

    public function delete(string $path, callable|array $handler): RouteDefinition
    {
        return $this->add('DELETE', $path, $handler);
    }

    /**
     * @throws Exception
     */
    public function dispatch(string $uri, string $method)
    {
        $path = parse_url($uri, PHP_URL_PATH) ?? '/';
        $method = strtoupper($method);

        if (!isset($this->routes[$method])) {
            throw new Exception("Method $method not allowed", 405);
        }

        foreach ($this->routes[$method] as $route) {
            if (preg_match($route->getRegex(), $path, $matches)) {
                array_shift($matches);

                $request = new Request();

                foreach ($route->getMiddleware() as $middlewareClass) {
                    if (!class_exists($middlewareClass)) {
                        throw new Exception("Middleware $middlewareClass not found");
                    }

                    $middleware = new $middlewareClass();
                    if (!$middleware instanceof Middleware) {
                        throw new Exception("$middlewareClass must extend App\Core\Middleware");
                    }

                    $middleware->handle($request);
                }

                $handler = $route->getHandler();

                if (is_array($handler)) {
                    [$class, $action] = $handler;
                    if (!class_exists($class)) {
                        throw new Exception("Controller $class not found");
                    }
                    $controller = new $class();
                    if (!method_exists($controller, $action)) {
                        throw new Exception("Method $action not found in $class");
                    }
                    return $controller->$action(...$matches);
                }

                return call_user_func_array($handler, $matches);
            }
        }

        throw new Exception("Route not found: [$method] $path", 404);
    }
}