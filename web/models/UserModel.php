<?php

class UsereModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function list()
    {
        $stmt = $this->db->prepare("SELECT * FROM users");
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($users as &$user) {
            $user['roles'] = $this->convertPostgresArrayToPHPArray($user['roles']);
        }

        return [
            'status_code' => 200,
            'status' => 'success',
            'message' => '',
            'data' => $users
        ];
    }

    private function convertPostgresArrayToPHPArray($postgresArray)
    {
        // Use PostgreSQL's string representation of arrays directly
        return str_getcsv(trim($postgresArray, '{}'));
    }
}