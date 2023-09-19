<?php

function createTable($tableName, $columns)
{
    global $db;

    $columnStr = implode(', ', array_map(function ($name, $type) {
        return "$name $type";
    }, array_keys($columns), $columns));

    $db->exec("
        CREATE TABLE $tableName (
            $columnStr,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )
    ");
}
