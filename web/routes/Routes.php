<?php

class Router
{

    public $routes;
    
    function __construct()
    {
        $this->routes = [
            'GET' => [
                '/' => 'DashboardController:index',
                '/recipes' => 'RecipeController:list',
                '/recipes/{id}' => 'RecipeController:getById',
                '/users' => 'UserController:list',
                '/recipes/{id}/ratings' => 'RatingController:getByRecipeId',
                '/recipes/search/{q}' => 'RecipeController:search',
            ],
            'POST' => [
                '/recipes' => 'RecipeController:create',
                '/recipes/{id}/ratings' => 'RatingController:create',
            ],
            'PUT' => [
                '/recipes/{id}' => 'RecipeController:update',
            ],
            'PATCH' => [
                '/recipes/{id}' => 'RecipeController:update',
            ],
            'DELETE' => [
                '/recipes/{id}' => 'RecipeController:delete',
            ],
        ];    
    }

    function handleRequest($uri,$method)
    {
        $path = parse_url($uri, PHP_URL_PATH);

        if(!isset($this->routes[$method])){
            header('Content-Type: application/json');
            echo json_encode([
                'status_code' => 405,
                'status' => 'error',
                'message' => 'Method Not Supported',
                'data' => []
            ]);
            return;
        }

        foreach ($this->routes[$method] as $route => $action) {
            $pattern = $this->convertRouteToPattern($route);
            if (preg_match($pattern, $path, $matches)) {
                $this->dispatch($action, $matches);
                return;
            }
        }

        header('Content-Type: application/json');
        echo json_encode([
            'status_code' => 404,
            'status' => 'error',
            'message' => 'Not Found',
            'data' => []
        ]);
        return;
    }

    protected function convertRouteToPattern($route)
    {
        // Convert route to regex pattern
        return '#^' . preg_replace('/{[^\/]+}/', '([^\/]+)', $route) . '$#';
    }

    protected function dispatch($action, $matches)
    {
        list($controllerName, $method) = explode(':', $action);
        $controller = new $controllerName();

        // Pass parameters from route to the method
        $params = array_slice($matches, 1);
        if (method_exists($controller, $method)) {
            call_user_func_array([$controller, $method], $params);
        } else {
            header('Content-Type: application/json');
            echo json_encode([
                'status_code' => 500,
                'status' => 'error',
                'message' => 'Server Error',
                'data' => []
            ]);
            return;
        }
    }
}