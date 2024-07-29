<?php

require_once __DIR__ . '/../utils/Database.php';

class SeedUsers
{
    public $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function run()
    {
        $users = [
            ['email' => 'user1@test.com', 'password' => password_hash('password123', PASSWORD_DEFAULT), 'roles' => '{user}'],
            ['email' => 'user2@test.com', 'password' => password_hash('password123', PASSWORD_DEFAULT), 'roles' => '{admin,user}'],
        ];

        foreach ($users as $user) {
            $check = $this->insertUser($user);
            if($check){
                echo "Users seeded successfully.\n";
            }
        }
    }

    private function insertUser($user)
    {
         // Check if user already exists
         $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
         $stmt->execute(['email' => $user['email']]);
         $exists = $stmt->fetchColumn();
 
         if (!$exists) {
            // User does not exist, so insert it
            $stmt = $this->db->prepare("INSERT INTO users (email, password, roles) VALUES (:email, :password, :roles)");
            $stmt->execute($user);
         } else {
             echo "User with email {$user['email']} already seeded.\n";
         }
    }
}

$seeder = new SeedUsers();
$seeder->run();
