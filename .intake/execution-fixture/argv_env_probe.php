<?php

echo json_encode(array(
    'cwd' => getcwd(),
    'argv' => $argv,
    'env' => array(
        'IDE_MCP_PROBE' => getenv('IDE_MCP_PROBE') ?: null,
    ),
    'php_version' => PHP_VERSION,
), JSON_PRETTY_PRINT) . PHP_EOL;
