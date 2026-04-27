<?php

require_once __DIR__ . '/src/Task.php';
require_once __DIR__ . '/src/TaskRepository.php';
require_once __DIR__ . '/src/TaskService.php';

use FocusLedger\TaskRepository;
use FocusLedger\TaskService;

function focus_ledger_service($dataFile)
{
    return new TaskService(new TaskRepository($dataFile));
}
