<?php
$migrationFiles = glob(__DIR__ . '/../Migration/db/*.php');

if (empty($migrationFiles)) {
    echo "No migration scripts found in 'db/' directory.<br>";
} else {
    echo "Executing migration scripts for the first time...<br>";
    sort($migrationFiles);

    foreach ($migrationFiles as $file) {
        echo "Executing $file...<br>";
        require_once $file;
    }

    echo "Migrations executed successfully.<br>";
}
