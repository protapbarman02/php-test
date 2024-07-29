<?php

class RatingController
{
    private $ratingModel;
    private $recipeModel;
    private $auth;

    public function __construct()
    {
        $this->ratingModel = new RatingModel();
        $this->recipeModel = new RecipeModel();
        $this->auth = new Auth();
    }

    public function create($recipe_id)
    {
        $this->auth->loginRequired();

        $data = json_decode(file_get_contents('php://input'), true);

        $recipe = $this->recipeModel->getById($recipe_id);

        if ($recipe['status_code'] !== 200) {
            header('Content-Type: application/json');
            echo json_encode($recipe);
            exit;
        }


        if ($this->isUniqueRating(intval($recipe_id), $_SESSION['user']['id'])) {

            $data['recipe_id'] = intval($recipe_id);
            $data['created_by'] = $_SESSION['user']['id'];

            $result = $this->ratingModel->create($data);

            header('Content-Type: application/json');
            echo json_encode($result);
        } else {
            header('Content-Type: application/json');
            echo  json_encode([
                'status_code' => 400,
                'status' => 'error',
                'message' => 'Already Rated this Recipe',
                'data' => []
            ]);
        }
    }

    public function getByRecipeId($recipe_id)
    {
        $recipe = $this->recipeModel->getById($recipe_id);

        if ($recipe['status_code'] !== 200) {
            header('Content-Type: application/json');
            echo json_encode($recipe);
            exit;
        }

        $result = $this->ratingModel->getByRecipeId($recipe_id);

        header('Content-Type: application/json');
        echo json_encode($result);
    }

    private function isUniqueRating($recipe_id, $created_by)
    {
        $isRated = $this->ratingModel->isUniqueRating($recipe_id, $created_by);
        return $isRated;
    }
}
