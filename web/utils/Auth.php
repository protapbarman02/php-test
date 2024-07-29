<?php

class Auth
{
    public $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function loginRequired()
    {
        header('Content-Type: application/json');

        if (!isset($_SESSION['user'])) {
            echo json_encode([
                'status_code' => 401,
                'status' => 'error',
                'message' => 'Unauthorized',
                'data' => ''
            ]);
            exit;
        }
    }

    public function roleRequired($roles)
    {
        header('Content-Type: application/json');

        if(!$this->compareRoles($roles)){
            echo json_encode([
                'status_code' => 403,
                'status' => 'error',
                'message' => 'Permission Denied',
                'data' => ''
            ]);
            exit;
        }


    }
    private function convertPostgresArrayToPHPArray($postgresArray)
    {
        return str_getcsv(trim($postgresArray, '{}'));
    }

    private function compareRoles($roles){
        $user =  $_SESSION['user'];
        $user['roles'] = $this->convertPostgresArrayToPHPArray($user['roles']);

        foreach ($roles as $role) {
            if (in_array($role, $user['roles'])) {
                return true;
            }
        }
        return false;
    }
}
