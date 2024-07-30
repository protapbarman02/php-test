<?php

class RecipeController
{
    private $recipeModel;
    private $ratingModel;
    private $auth;

    public function __construct()
    {
        $this->recipeModel = new RecipeModel();
        $this->ratingModel = new RatingModel();
        $this->auth = new Auth();
    }

    public function list()
    {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $offset = ($page - 1) * $limit;

        $recipes = $this->recipeModel->list($limit, $offset, $search);
        $totalCount = $this->recipeModel->getTotalCount($search);

        $updatedData = [];

        foreach ($recipes['data'] as $recipe) {
            $ratings = $this->ratingModel->getByRecipeId($recipe['id']);
            $recipe['ratings'] = $ratings['data'];
            $updatedData[] = $recipe;
        }

        $totalPages = ceil($totalCount / $limit);
        $prevPage = $page > 1 ? "http://localhost/recipes?limit={$limit}&page=" . ($page - 1) . "&search={$search}" : null;
        $nextPage = $page < $totalPages ? "http://localhost/recipes?limit={$limit}&page=" . ($page + 1) . "&search={$search}" : null;   

        $response = [
            'status' => 'success',
            'status_code' => 200,
            'message' => 'Successfully fetched Recipes',
            'data' => [
                'recipes' => $updatedData,
                'limit' => $limit,
                'total' => $totalCount,
                'total_page' => $totalPages,
                'current_page' => $page,
                'prev_page' => $prevPage,
                'next_page' => $nextPage
            ]
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
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
        $this->auth->loginRequired();

        $recipe = json_decode(file_get_contents('php://input'), true);
        $result = $this->recipeModel->create($recipe);

        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    }

    public function update($id)
    {
        $this->auth->loginRequired();
        $this->auth->roleRequired(['admin']);

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
        $this->auth->loginRequired();
        $this->auth->roleRequired(['admin']);

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
}
