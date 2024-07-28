<?php
require_once __DIR__.'/../utils/Database.php';

$check = Database::getInstance()->getConnection();
print_r($check);