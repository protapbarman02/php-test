<?php

class RecipeModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function list($limit, $offset, $search = '')
    {
        try {
            $sql = "SELECT * FROM recipes";
            if (!empty($search)) {
                $sql .= " WHERE name LIKE :search";
            }
            $sql .= " LIMIT :limit OFFSET :offset";

            $stmt = $this->db->prepare($sql);
            if (!empty($search)) {
                $searchParam = "%$search%";
                $stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
            }

            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();

            $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($recipes as &$recipe) {
                $recipe['url'] = SERVER_PATH . 'recipes/' . $recipe['id'];
            }

            return [
                'status_code' => 200,
                'status' => 'success',
                'message' => 'Successfully fetched Recipes',
                'data' => $recipes
            ];
        } catch (PDOException $e) {
            return [
                'status_code' => 500,
                'status' => 'error',
                'message' => 'Internal Server Error',
                'data' => []
            ];
        }
    }

    public function getTotalCount($search = '')
    {
        try {
            $sql = "SELECT COUNT(*) as total FROM recipes";
            if (!empty($search)) {
                $sql .= " WHERE name LIKE :search";
            }

            $stmt = $this->db->prepare($sql);
            if (!empty($search)) {
                $searchParam = "%$search%";
                $stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
            }
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int)$result['total'];
        } catch (PDOException $e) {
            return 0;
        }
    }

    public function getById($id)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM recipes WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $recipe = $stmt->fetch(PDO::FETCH_ASSOC);


            $status_code = 200;
            $status = 'success';
            $message = 'Successfully fetched Recipe';
            $data = $recipe;

            if ($recipe === false) {
                $status_code = 404;
                $status = 'error';
                $message = 'Recipe Not Found';
                $data = [];
            }

            return [
                'status_code' => $status_code,
                'status' => $status,
                'message' => $message,
                'data' => $data
            ];
        } catch (PDOException $e) {
            return [
                'status_code' => 500,
                'status' => 'error',
                'message' => 'Internal Server Error',
                'data' => ''
            ];
        }
    }

    public function create($data)
    {
        if (!isset($data['difficulty']) || ($data['difficulty'] < 1 || $data['difficulty'] > 3)) {
            return [
                'status_code' => 501,
                'status' => 'error',
                'message' => 'Invalid Difficulty Value',
                'data' => ''
            ];
        }

        try {
            $stmt = $this->db->prepare(
                "INSERT INTO recipes (name, prep_time, difficulty, vegetarian) VALUES (:name, :prep_time, :difficulty, :vegetarian)"
            );
            $stmt->bindParam(':name', $data['name'], PDO::PARAM_STR);
            $stmt->bindParam(':prep_time', $data['prep_time'], PDO::PARAM_INT);
            $stmt->bindParam(':difficulty', $data['difficulty'], PDO::PARAM_INT);
            $stmt->bindParam(':vegetarian', $data['vegetarian'], PDO::PARAM_BOOL);
            $stmt->execute();


            $recipeId = $this->db->lastInsertId();
            $recipe = $this->getById($recipeId);

            $message = 'Recipe Created Successfully';
            $data = $recipe['data'];

            if ($recipe['status_code'] !== 200) {
                $message = 'Recipe Created Successfully but failed to fetch the Recipe, do not worry';
                $data = [];
            }

            return [
                'status_code' => 201,
                'status' => 'success',
                'message' => $message,
                'data' => $data
            ];
        } catch (PDOException $e) {
            return [
                'status_code' => 500,
                'status' => 'error',
                'message' => 'Internal Server Error',
                'data' => ''
            ];
        }
    }

    public function update($id, $data)
    {

        if (!isset($data['difficulty']) || ($data['difficulty'] < 1 || $data['difficulty'] > 3)) {
            return [
                'status_code' => 501,
                'status' => 'error',
                'message' => 'Invalid Difficulty Value',
                'data' => ''
            ];
        }

        try {
            $stmt = $this->db->prepare(
                "UPDATE recipes 
                 SET name = :name, prep_time = :prep_time, difficulty = :difficulty, vegetarian = :vegetarian 
                 WHERE id = :id"
            );
            $stmt->bindParam(':name', $data['name'], PDO::PARAM_STR);
            $stmt->bindParam(':prep_time', $data['prep_time'], PDO::PARAM_INT);
            $stmt->bindParam(':difficulty', $data['difficulty'], PDO::PARAM_INT);
            $stmt->bindParam(':vegetarian', $data['vegetarian'], PDO::PARAM_BOOL);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $recipe = $this->getById($id);

            $message = 'Recipe Updated Successfully';

            if ($recipe['status_code'] !== 200) {
                $message = 'Recipe Updated Successfully but failed to fetch the Recipe, do not worry';
            }

            return [
                'status_code' => 201,
                'status' => 'success',
                'message' => $message,
                'data' => $recipe['data']
            ];
        } catch (PDOException $e) {
            return [
                'status_code' => 500,
                'status' => 'error',
                'message' => 'Internal Server Error',
                'data' => ''
            ];
        }
    }

    public function delete($id)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM recipes WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $recipe = $stmt->fetch(PDO::FETCH_ASSOC);

            return [
                'status_code' => 200,
                'status' => 'success',
                'message' => 'Successfully Deleted Recipe',
                'data' => []
            ];
        } catch (PDOException $e) {
            return [
                'status_code' => 500,
                'status' => 'error',
                'message' => 'Internal Server Error',
                'data' => ''
            ];
        }
    }
}
