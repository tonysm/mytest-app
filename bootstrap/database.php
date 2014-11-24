<?php

$db_config = require __DIR__ . "/../config/database.php";

try {
    $db = new PDO(
        "{$db_config['driver']}:host={$db_config['host']};port={$db_config['port']};dbname={$db_config['database']}",
        $db_config['username'],
        $db_config['password']
    );
}
catch (PDOException $e) {
    die($e->getMessage());
}