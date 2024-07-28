<?php

class RatingModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create($data) 
    {
        if (!isset($data['rating']) || ($data['rating']<1 || $data['rating']>5)) {
            return [
                'status_code' => 501,
                'status' => 'error',
                'message' => 'Invalid Rating Value',
                'data' => ''
            ];
        }

        try{
            $stmt = $this->db->prepare(
                "INSERT INTO ratings (recipe_id, rating) VALUES (:recipe_id, :rating)"
            );
            $stmt->bindParam(':recipe_id', $data['recipe_id'], PDO::PARAM_INT);
            $stmt->bindParam(':rating', $data['rating'], PDO::PARAM_INT);
            $stmt->execute();
            
            $ratingId = $this->db->lastInsertId();
            $rating = $this->getById($ratingId);

            return [
                'status_code' => 201,
                'status' => 'success',
                'message' => 'Sucessfully Rated',
                'data' => $rating['data']
            ];

        } catch(PDOException $e){
            return [
                'hello' => 'I am here',
                'status_code' => 500,
                'status' => 'error', 
                'message' => $e->getMessage(),
                'data' => ''
            ];
        }
    }

    public function getById($id)
    {
        try{
            $stmt = $this->db->prepare("SELECT * FROM ratings WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $recipe = $stmt->fetch(PDO::FETCH_ASSOC);

            return [
                'status_code' => 200,
                'status' => 'success', 
                'message' => 'ratings fetched successfully',
                'data' => $recipe
            ];
        } catch(PDOException $e){
            return [
                'status_code' => 500,
                'status' => 'error', 
                'message' => 'Internal Server Error',
                'data' => ''
            ];
        }
    }

    public function getByRecipeId($recipeId)
    {
        try{
            $stmt = $this->db->prepare("SELECT * FROM ratings WHERE recipe_id = :recipe_id");
            $stmt->bindParam(':recipe_id', $recipeId, PDO::PARAM_INT);
            $stmt->execute();
            $ratings = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return [
                'status_code' => 200,
                'status' => 'success', 
                'message' => 'ratings fetched successfully',
                'data' => $ratings
            ];
        } catch(PDOException $e){
            return [
                'status_code' => 500,
                'status' => 'error', 
                'message' => 'Internal Server Error',
                'data' => ''
            ];
        }
    }
}