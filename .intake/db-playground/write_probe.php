<?php

$host = getenv('PHPSTORMTEST_DB_HOST') ?: 'localhost';
$port = getenv('PHPSTORMTEST_DB_PORT') ?: '3307';
$database = getenv('PHPSTORMTEST_DB_NAME') ?: 'phpstormtest';
$user = getenv('PHPSTORMTEST_DB_USER') ?: 'phpstormtest';
$password = getenv('PHPSTORMTEST_DB_PASSWORD') ?: 'phpstormtest';
$table = getenv('PHPSTORMTEST_DB_TABLE') ?: 'ide_mcp_probe';

$dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4', $host, $port, $database);
$pdo = new PDO($dsn, $user, $password, array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
));

$pdo->exec(
    'CREATE TABLE IF NOT EXISTS `' . $table . '` (
        id INT AUTO_INCREMENT PRIMARY KEY,
        label VARCHAR(120) NOT NULL,
        status VARCHAR(40) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4'
);

$columnCheck = $pdo->prepare(
    'SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
     WHERE TABLE_SCHEMA = :schema AND TABLE_NAME = :table AND COLUMN_NAME = :column'
);
$columnCheck->execute(array(
    'schema' => $database,
    'table' => $table,
    'column' => 'notes',
));

if ((int) $columnCheck->fetchColumn() === 0) {
    $pdo->exec('ALTER TABLE `' . $table . '` ADD COLUMN notes VARCHAR(255) NULL');
}

$pdo->exec('TRUNCATE TABLE `' . $table . '`');

$insert = $pdo->prepare('INSERT INTO `' . $table . '` (label, status, notes) VALUES (:label, :status, :notes)');
$insert->execute(array(
    'label' => 'create-table',
    'status' => 'ok',
    'notes' => 'Table was created or already existed.',
));
$insert->execute(array(
    'label' => 'alter-table',
    'status' => 'ok',
    'notes' => 'Column notes is present.',
));
$insert->execute(array(
    'label' => 'read-data',
    'status' => 'pending',
    'notes' => 'This row is updated before readback.',
));

$update = $pdo->prepare('UPDATE `' . $table . '` SET status = :status WHERE label = :label');
$update->execute(array(
    'status' => 'ok',
    'label' => 'read-data',
));

$rows = $pdo->query('SELECT id, label, status, notes FROM `' . $table . '` ORDER BY id')->fetchAll();
$columns = $pdo->prepare(
    'SELECT COLUMN_NAME, DATA_TYPE, IS_NULLABLE
     FROM INFORMATION_SCHEMA.COLUMNS
     WHERE TABLE_SCHEMA = :schema AND TABLE_NAME = :table
     ORDER BY ORDINAL_POSITION'
);
$columns->execute(array(
    'schema' => $database,
    'table' => $table,
));

echo json_encode(array(
    'database' => $database,
    'table' => $table,
    'operations' => array(
        'create_table' => 'ok',
        'alter_table_add_notes' => 'ok',
        'truncate_test_table' => 'ok',
        'insert_rows' => count($rows),
        'update_row' => 'ok',
        'read_rows' => 'ok',
    ),
    'columns' => $columns->fetchAll(),
    'rows' => $rows,
), JSON_PRETTY_PRINT) . PHP_EOL;
