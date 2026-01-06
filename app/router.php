<?php
class Router
{
    public function dispatch()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $base = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
        $path = trim(substr($uri, strlen($base)), '/');

        // Ensure $parts is always defined as an array
        $parts = [];

        if ($path === '') {
            $controllerName = 'HomeController';
            $action = 'index';
        } else {
            $parts = explode('/', $path);
            $controllerName = ucfirst(array_shift($parts)) . 'Controller';
            $action = array_shift($parts) ?: 'index';
        }

        $controllerFile = __DIR__ . '/controllers/' . $controllerName . '.php';
        if (!file_exists($controllerFile)) {
            http_response_code(404);
            echo 'Controller not found';
            return;
        }

        require_once $controllerFile;

        if (!class_exists($controllerName)) {
            http_response_code(500);
            echo 'Controller class missing';
            return;
        }

        $controller = new $controllerName();

        if (!method_exists($controller, $action)) {
            http_response_code(404);
            echo 'Action not found';
            return;
        }

        // Pass any remaining URL segments as parameters to the action
        $params = is_array($parts) ? $parts : [];
        call_user_func_array([$controller, $action], $params);
    }
}
