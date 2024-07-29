<?php

class AuthController
{
    public $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function login()
    {
        header('Content-Type: application/json');

        $input = json_decode(file_get_contents('php://input'), true);

        if (!isset($input['email']) || !isset($input['password'])) {
            echo json_encode([
                'status_code' => 401,
                'status' => 'error',
                'message' => 'Email and Password required',
                'data' => ''
            ]);
        }

        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $input['email']);

        try {
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($input['password'], $user['password'])) {

                $_SESSION['user'] = $user;
                
                echo json_encode([
                    'status_code' => 200,
                    'status' => 'success',
                    'message' => 'Login Successfull',
                    'data' => $user
                ]);
            } else {
                echo json_encode([
                    'status_code' => 401,
                    'status' => 'error',
                    'message' => 'Invalid Credentials',
                    'data' => ''
                ]);
            }
        } catch (PDOException $e) {
            echo json_encode([
                'status_code' => 500,
                'status' => 'error',
                'message' => 'Internal Server Error',
                'data' => ''
            ]);
        }
    }

    public function logout()
    {
        unset($_SESSION['auth_data']);
        session_destroy();

        header('Content-Type: application/json');
        echo json_encode([
            'status_code' => 200,
            'status' => 'success',
            'message' => 'Logged Out Successfully',
            'data' => ''
        ]);
    }

}
