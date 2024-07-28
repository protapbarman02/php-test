<?php

class Router{

    public $routes;
    
    function __construct(){
        $this->routes = [
            'GET' => [
                '/' => 'DashboardController:index',
                '/recipes' => 'RecipeController:list',
                '/recipes/{id}' => 'RecipeController:get',
                '/users' => 'UserController:list'
            ],
            'POST' => [
                '/recipes' => 'RecipeController:create',
                '/recipes/{id}/rating' => 'RecipeController:rate',
            ],
            'PUT' => [
                '/recipes/{id}' => 'RecipeController:update',
            ],
            'DELETE' => [
                '/recipes/{id}' => 'RecipeController:delete',
            ],
        ];    
    }

    function extractURL(){

    }

    function handleRequest($uri,$method){
        $path = parse_url($uri, PHP_URL_PATH);
        if(!isset($this->routes[$method])){
            echo "Error";
            return;
            //return standard error json
        }
        foreach ($this->routes[$method] as $route => $action) {
            $pattern = $this->convertRouteToPattern($route);
            if (preg_match($pattern, $path, $matches)) {
                $this->dispatch($action, $matches);
                return;
            }
        }
    }
    protected function convertRouteToPattern($route)
    {
        // Convert route to regex pattern
        return '#^' . preg_replace('/{id}/', '(\d+)', $route) . '$#';
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
            echo "Error";
            return;
            //return standard error json
        }
    }
}