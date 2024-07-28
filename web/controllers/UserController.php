<?php

class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UsereModel();
    }

    public function list()
    {
        $users = $this->userModel->list();
        
        header('Content-Type: application/json');
        echo json_encode([
            'status_code' => 200,
            'status' => 'success',
            'message' => '',
            'data' => $users
        ]);
        exit;
    }
}
