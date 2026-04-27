<?php

require_once __DIR__ . '/../src/UsedClass.php';
require_once __DIR__ . '/../src/CleanupTarget.php';

use DestructiveFixture\CleanupTarget;
use DestructiveFixture\UsedClass;

$used = new UsedClass();
if ($used->ping() !== 'used') {
    fwrite(STDERR, 'UsedClass failed.' . PHP_EOL);
    exit(1);
}

$target = new CleanupTarget('demo');
if ($target->calculate(2, 3) !== 5) {
    fwrite(STDERR, 'CleanupTarget failed.' . PHP_EOL);
    exit(1);
}

echo 'Destructive fixture tests passed.' . PHP_EOL;
