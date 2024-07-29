<?php

class RecipeController
{
    private $recipeModel;
    private $ratingModel;

    public function __construct()
    {
        $this->recipeModel = new RecipeModel();
        $this->ratingModel = new RatingModel();
    }

    public function list()
    {
        $recipes = $this->recipeModel->list();

        $updatedData = [];

        foreach ($recipes['data'] as $recipe) {
            $ratings = $this->ratingModel->getByRecipeId($recipe['id']);
            $recipe['ratings'] = $ratings['data'];
            $updatedData[] = $recipe;
        }
        $recipes['data'] = $updatedData;

        header('Content-Type: application/json');
        echo json_encode($recipes);
        exit;
    }

    public function getById($id)
    {
        $recipe = $this->recipeModel->getById($id);

        $ratings = $this->ratingModel->getByRecipeId($recipe['data']['id']);
        $recipe['data']['ratings'] = $ratings['data'];

        header('Content-Type: application/json');
        echo json_encode($recipe);
        exit;
    }

    public function create()
    {
        $recipe = json_decode(file_get_contents('php://input'), true);
        $result = $this->recipeModel->create($recipe);

        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    }

    public function update($id)
    {
        $recipe = $this->recipeModel->getById($id);

        if ($recipe['status_code'] !== 200) {
            header('Content-Type: application/json');
            echo json_encode($recipe);
            exit;
        }

        $updated_recipe = json_decode(file_get_contents('php://input'), true);
        $result = $this->recipeModel->update($id, $updated_recipe);

        header('Content-Type: application/json');
        echo json_encode($result);
    }

    public function delete($id)
    {
        $recipe = $this->recipeModel->getById($id);

        if ($recipe['status_code'] !== 200) {
            header('Content-Type: application/json');
            echo json_encode($recipe);
            exit;
        }

        $result = $this->recipeModel->delete($id);

        header('Content-Type: application/json');
        echo json_encode($result);
    }

    public function search($q)
    {
        $recipes = $this->recipeModel->search($q);

        $updatedData = [];

        foreach ($recipes['data'] as $recipe) {
            $ratings = $this->ratingModel->getByRecipeId($recipe['id']);
            $recipe['ratings'] = $ratings['data'];
            $updatedData[] = $recipe;
        }
        $recipes['data'] = $updatedData;

        header('Content-Type: application/json');
        echo json_encode($recipes);
    }
}
