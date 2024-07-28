<?php
require_once __DIR__.'/../utils/Database.php';
require_once __DIR__.'/../models/RecipeModel.php';
require_once __DIR__.'/../models/UserModel.php';
require_once __DIR__.'/../controllers/RecipeController.php';
require_once __DIR__.'/../controllers/UserController.php';
require_once __DIR__.'/../routes/Routes.php';

$router = new Router();
$router->handleRequest($_SERVER['REQUEST_URI'],$_SERVER['REQUEST_METHOD']);
