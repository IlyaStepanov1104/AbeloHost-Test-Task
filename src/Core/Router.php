<?php

namespace App\Core;

use App\Controllers\ErrorController;

class Router
{
    private array $routes = [];
    private array $dynamicRoutes = [];

    public function get(string $path, string $controller, string $action): void
    {
        if (str_contains($path, ':')) {
            $this->addDynamic('GET', $path, $controller, $action);
        } else {
            $this->routes['GET'][$path] = [$controller, $action];
        }
    }

    // For API:
    // public function post(string $path, string $controller, string $action): void
    // public function put(string $path, string $controller, string $action): void
    // public function delete(string $path, string $controller, string $action): void

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $this->normalize(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

        if (isset($this->routes[$method][$uri])) {
            [$controllerClass, $action] = $this->routes[$method][$uri];
            $this->callAction($controllerClass, $action, []);
            return;
        }

        foreach ($this->dynamicRoutes[$method] ?? [] as [$pattern, $paramNames, $controllerClass, $action]) {
            if (preg_match($pattern, $uri, $matches)) {
                $params = [];
                foreach ($paramNames as $name) {
                    $params[$name] = $matches[$name];
                }
                $this->callAction($controllerClass, $action, $params);
                return;
            }
        }

        $this->abort(404);
    }

    public function abort(int $code): void
    {
        $error = new ErrorController();
        $error->index($code);
    }

    private function addDynamic(string $method, string $path, string $controller, string $action): void
    {
        preg_match_all('/:([a-zA-Z_][a-zA-Z0-9_]*)/', $path, $m);
        $paramNames = $m[1];

        $escaped = preg_quote($path, '#');
        $pattern = preg_replace('/\\\\:([a-zA-Z_][a-zA-Z0-9_]*)/', '(?P<$1>[^/]+)', $escaped);
        $pattern = '#^' . $pattern . '$#';

        $this->dynamicRoutes[$method][] = [$pattern, $paramNames, $controller, $action];
    }

    private function callAction(string $controllerClass, string $action, array $params): void
    {
        $fullClass = "App\\Controllers\\$controllerClass";

        if (!class_exists($fullClass)) {
            $this->abort(500);
            return;
        }

        $controller = new $fullClass();

        if (!method_exists($controller, $action)) {
            $this->abort(500);
            return;
        }

        $controller->$action($params);
    }

    private function normalize(string $path): string
    {
        $path = rtrim($path, '/');
        return $path === '' ? '/' : $path;
    }
}
