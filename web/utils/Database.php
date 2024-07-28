<?php
class Database{
    
    public $connection;
    public static $instance = null;

    function __construct(){
        $config = require_once __DIR__.'/../config/db.php';
        $this->connection = new PDO(
            "pgsql:host={$config['host']};dbname={$config['db']}",
            $config['username'],
            $config['password']
        );
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    function getConnection(){
        return $this->connection;
    }

    // function getConfig(){
    //     $config = require_once '../config/db.php';
    //     echo $config['host']."<br>";
    //     echo $config['db']."<br>";
    //     echo $config['username']."<br>";
    //     echo $config['password']."<br>";
    // }
}