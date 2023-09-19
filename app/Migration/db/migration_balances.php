<?php

require_once __DIR__ . '/../migrations.php';

$tableName = 'balances';
$columns = [
    'id'          => 'INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY',
    'trx_id'      => 'uuid NOT NULL DEFAULT uuid()',
    'trx_type'    => 'varchar(20) NOT NULL',
    'user_id'     => 'int(11) NOT NULL',
    'destination' => 'int(11) DEFAULT NULL',
    'amount'      => 'double NOT NULL',
    'balance'     => 'double NOT NULL',
    'description' => 'text DEFAULT NULL',
];

createTable($tableName, $columns);
