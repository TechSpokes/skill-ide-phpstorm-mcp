<?php

$host = getenv('PHPSTORMTEST_DB_HOST') ?: 'localhost';
$port = getenv('PHPSTORMTEST_DB_PORT') ?: '3307';
$database = getenv('PHPSTORMTEST_DB_NAME') ?: 'phpstormtest';
$user = getenv('PHPSTORMTEST_DB_USER') ?: 'phpstormtest';
$password = getenv('PHPSTORMTEST_DB_PASSWORD') ?: 'phpstormtest';

$dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4', $host, $port, $database);
$pdo = new PDO($dsn, $user, $password, array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
));

$metadata = $pdo->query('SELECT DATABASE() AS db_name, VERSION() AS server_version, CURRENT_USER() AS current_user_name')->fetch();
$tables = $pdo->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);

echo json_encode(array(
    'metadata' => $metadata,
    'tables' => $tables,
    'table_count' => count($tables),
), JSON_PRETTY_PRINT) . PHP_EOL;
