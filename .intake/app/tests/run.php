<?php

require_once __DIR__ . '/../bootstrap.php';

use FocusLedger\TaskRepository;
use FocusLedger\TaskService;

$fixture = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'focus-ledger-test-' . uniqid('', true) . '.json';
copy(__DIR__ . '/../data/tasks.json', $fixture);

$service = new TaskService(new TaskRepository($fixture));
$openTasks = $service->listActiveTasks();
$completedTasks = $service->countCompletedTasks();

if (count($openTasks) !== 2) {
    fwrite(STDERR, 'Expected 2 open tasks, got ' . count($openTasks) . PHP_EOL);
    exit(1);
}

if ($completedTasks !== 1) {
    fwrite(STDERR, 'Expected 1 completed task, got ' . $completedTasks . PHP_EOL);
    exit(1);
}

$newTask = $service->addTask('Verify MCP rename refactor', 'high');
if ($newTask->getId() !== 4) {
    fwrite(STDERR, 'Expected new task id 4, got ' . $newTask->getId() . PHP_EOL);
    exit(1);
}

unlink($fixture);
echo 'All Focus Ledger tests passed.' . PHP_EOL;
