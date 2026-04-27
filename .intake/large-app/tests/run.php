<?php

require_once __DIR__ . '/../bootstrap.php';

use LargeFixture\Handlers\EmailTaskHandler;
use LargeFixture\Handlers\SmsTaskHandler;
use LargeFixture\Handlers\WebhookTaskHandler;
use LargeFixture\Reporting\JsonReporter;
use LargeFixture\Services\DispatchService;
use LargeFixture\Services\ReportService;
use LargeFixture\Services\UnusedWarningService;

$dispatch = new DispatchService(array(
    new EmailTaskHandler(),
    new SmsTaskHandler(),
    new WebhookTaskHandler(),
));

$results = $dispatch->dispatchAll(array(
    'subject' => 'Large fixture',
    'number' => '+15550000000',
    'url' => 'https://example.test/hook',
));

if (count($results) !== 3) {
    fwrite(STDERR, 'Expected 3 dispatch results.' . PHP_EOL);
    exit(1);
}

$report = new ReportService(new JsonReporter());
$json = $report->render($results);
if (strpos($json, 'Large fixture') === false) {
    fwrite(STDERR, 'Report did not include dispatch output.' . PHP_EOL);
    exit(1);
}

$warningService = new UnusedWarningService('demo');
if ($warningService->calculate(2, 3) !== 5) {
    fwrite(STDERR, 'Calculation failed.' . PHP_EOL);
    exit(1);
}

echo 'Large fixture tests passed.' . PHP_EOL;
