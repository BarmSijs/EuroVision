<?php

declare(strict_types=1);

class Router
{
    public function dispatch(): void
    {
        // Volledige URI zonder query string
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $path = trim(substr($uri, strlen(BASE_PATH)), '/');

        // Default route
        if ($path === '') {
            $controllerName = 'HomeController';
            $action = 'index';
            $params = [];
        } else {
            $parts = explode('/', $path);

            // Extract controller, action, and parameters
            $controllerName = ucfirst($parts[0] ?? 'home') . 'Controller';
            $action = $parts[1] ?? 'index';
            $params = array_slice($parts, 2);
        }

        // Controller bestand
        $controllerFile = __DIR__ . '/controllers/' . $controllerName . '.php';

        if (!file_exists($controllerFile)) {
            http_response_code(404);
            echo 'Controller not found: ' . $controllerName;
            return;
        }

        require_once $controllerFile;

        if (!class_exists($controllerName)) {
            http_response_code(500);
            echo 'Controller class missing: ' . $controllerName;
            return;
        }

        $controller = new $controllerName();

        if (!method_exists($controller, $action)) {
            http_response_code(404);
            echo 'Action not found: ' . $action;
            return;
        }

        // Call controller action with parameters
        call_user_func_array([$controller, $action], $params);
    }
}
