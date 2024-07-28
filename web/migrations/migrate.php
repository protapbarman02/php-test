<?php

$migrations = [
    'create_tables.php',
];

foreach ($migrations as $migration) {
    require_once __DIR__ . '/' . $migration;
}

echo "Migrations completed.\n";
