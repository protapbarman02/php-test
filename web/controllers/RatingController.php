<?php

class RatingController 
{
    private $ratingModel;
    private $recipeModel;

    public function __construct()
    {
        $this->ratingModel = new RatingModel();
        $this->recipeModel = new RecipeModel();
    }

    public function create($recipe_id)
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $recipe = $this->recipeModel->getById($recipe_id);

        if($recipe['status_code'] !== 200){
            header('Content-Type: application/json');
            echo json_encode($recipe);
            exit;
        }

        $data['recipe_id'] = intval($recipe_id);

        // $created_by = 1;     find a way to get logged in user id

        $result = $this->ratingModel->create($data);

        header('Content-Type: application/json');
        echo json_encode($result);
    }

    public function getByRecipeId($recipe_id)
    {
        $recipe = $this->recipeModel->getById($recipe_id);

        if($recipe['status_code'] !== 200){
            header('Content-Type: application/json');
            echo json_encode($recipe);
            exit;
        }

        $result = $this->ratingModel->getByRecipeId($recipe_id);
        
        header('Content-Type: application/json');
        echo json_encode($result);
    }

}