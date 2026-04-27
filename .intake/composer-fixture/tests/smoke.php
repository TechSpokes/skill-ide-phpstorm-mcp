<?php

require_once __DIR__ . '/../vendor/autoload.php';

use ComposerFixture\ComposerProbe;

$probe = new ComposerProbe();
if ($probe->describe() !== 'composer fixture ready') {
    fwrite(STDERR, 'Composer fixture smoke test failed.' . PHP_EOL);
    exit(1);
}

echo 'Composer fixture smoke test passed.' . PHP_EOL;
