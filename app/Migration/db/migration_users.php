<?php

require_once __DIR__ . '/../migrations.php';

$tableName = 'users';
$columns = [
    'id' => 'INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY',
    'username' => 'VARCHAR(255) NOT NULL',
    'password' => 'VARCHAR(255) NOT NULL',
];

createTable($tableName, $columns);
