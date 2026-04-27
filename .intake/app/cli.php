<?php

require_once __DIR__ . '/bootstrap.php';

$dataFile = __DIR__ . '/data/tasks.json';
$service = focus_ledger_service($dataFile);
$command = isset($argv[1]) ? $argv[1] : 'list';

if ($command === 'add') {
    $title = isset($argv[2]) ? $argv[2] : 'Untitled task';
    $priority = isset($argv[3]) ? $argv[3] : 'medium';
    $task = $service->addTask($title, $priority);
    echo 'Added #' . $task->getId() . ': ' . $task->getTitle() . PHP_EOL;
    exit(0);
}

if ($command !== 'list') {
    fwrite(STDERR, 'Unknown command: ' . $command . PHP_EOL);
    exit(1);
}

foreach ($service->listActiveTasks() as $task) {
    echo sprintf('[%s] #%d %s', $task->getPriority(), $task->getId(), $task->getTitle()) . PHP_EOL;
}
