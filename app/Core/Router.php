<?php
class Router {
    private array $routes = [];

    public function get(string $path, array $handler): void {
        $this->routes['GET'][$path] = $handler;
    }

    public function post(string $path, array $handler): void {
        $this->routes['POST'][$path] = $handler;
    }

    public function dispatch(string $method, string $path): void {
        $path = parse_url($path, PHP_URL_PATH);

        // Kỹ thuật kiểm tra route có tồn tại không nhưng sai Method (405)
        $routeExists = false;
        foreach ($this->routes as $httpMethod => $paths) {
            if (isset($paths[$path])) {
                $routeExists = true;
                break;
            }
        }

        if (isset($this->routes[$method][$path])) {
            [$class, $action] = $this->routes[$method][$path];
            $controller = new $class();
            $controller->$action();
        } elseif ($routeExists) {
            http_response_code(405);
            render('errors/405', ['title' => '405 Method Not Allowed']);
        } else {
            http_response_code(404);
            render('errors/404', ['title' => '404 Not Found']);
        }
    }
}