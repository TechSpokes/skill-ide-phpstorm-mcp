<?php

require_once __DIR__ . '/../bootstrap.php';

$service = focus_ledger_service(__DIR__ . '/../data/tasks.json');
$openTasks = $service->listActiveTasks();
$completedCount = $service->countCompletedTasks();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Focus Ledger</title>
</head>
<body>
<h1>Focus Ledger</h1>
<p>Completed tasks: <?php echo htmlspecialchars((string)$completedCount, ENT_QUOTES, 'UTF-8'); ?></p>
<ul>
    <?php foreach ($openTasks as $task): ?>
        <li>
            <?php echo htmlspecialchars($task->getPriority(), ENT_QUOTES, 'UTF-8'); ?>:
            <?php echo htmlspecialchars($task->getTitle(), ENT_QUOTES, 'UTF-8'); ?>
        </li>
    <?php endforeach; ?>
</ul>
</body>
</html>
