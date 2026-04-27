<?php

foreach (array(
    '/src/Contracts/TaskHandler.php',
    '/src/Contracts/Reporter.php',
    '/src/Support/LogsActivity.php',
    '/src/Handlers/AbstractHandler.php',
    '/src/Handlers/EmailTaskHandler.php',
    '/src/Handlers/SmsTaskHandler.php',
    '/src/Handlers/WebhookTaskHandler.php',
    '/src/Reporting/JsonReporter.php',
    '/src/Reporting/TextReporter.php',
    '/src/Services/DispatchService.php',
    '/src/Services/ReportService.php',
    '/src/Services/UnusedWarningService.php',
) as $file) {
    require_once __DIR__ . $file;
}
