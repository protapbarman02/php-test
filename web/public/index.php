<?php
require_once "../utils/Database.php";

$check = Database::getInstance()->getConnection();
print_r($check);