<?php

class RecipeController {

    private $recipeModel;

    public function __construct() {
        $this->recipeModel = new RecipeModel();
    }

    public function list() {
        $recipes = $this->recipeModel->list();

        header('Content-Type: application/json');
        echo json_encode($recipes);
        exit;
    }

    public function getById($id) {
        $recipe = $this->recipeModel->getById($id);

        header('Content-Type: application/json');
        echo json_encode($recipe);
        exit;
    }
    
    public function create(){
        $recipe = json_decode(file_get_contents('php://input'), true);
        $result = $this->recipeModel->create($recipe);

        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    }

    public function update($id){
        $recipe = $this->recipeModel->getById($id);

        if($recipe['status_code'] !== 200){
            header('Content-Type: application/json');
            echo json_encode($recipe);
            exit;
        }

        $updated_recipe = json_decode(file_get_contents('php://input'), true);
        $result = $this->recipeModel->update($id, $updated_recipe);

        header('Content-Type: application/json');
        echo json_encode($result);
    }

    public function delete($id){
        $recipe = $this->recipeModel->getById($id);

        if($recipe['status_code'] !== 200){
            header('Content-Type: application/json');
            echo json_encode($recipe);
            exit;
        }

        $result = $this->recipeModel->delete($id);

        header('Content-Type: application/json');
        echo json_encode($result);
    }
    
    public function search($q) {
        $recipes = $this->recipeModel->search($q);
        header('Content-Type: application/json');
        echo json_encode($recipes);
    }
}
