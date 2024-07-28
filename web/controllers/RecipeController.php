<?php

class RecipeController {
    private $recipeModel;

    public function __construct() {
        $this->recipeModel = new RecipeModel();
    }

    public function list() {
        //handle search params
        //$queryParams = $_GET;
        //$queryParamsJson = json_encode($queryParams);

        $recipes = $this->recipeModel->getAll();

        header('Content-Type: application/json');
        echo json_encode([
            'status_code' => 200,
            'status' => 'success',
            'message' => '',
            'data' => $recipes
        ]);
    }
}
