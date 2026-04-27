# Composer Runtime

Use this reference when Composer, autoloading, scripts, or PHP runtime consistency matters.

## Runtime Mismatch

Do not assume global Composer uses the same PHP runtime as PhpStorm.

Intake testing found PhpStorm using PHP `8.2.29` while global Composer used PHP `8.1.26`. Composer validation worked, but a Composer script failed until the script was run through the project PHP interpreter.

## Required Checks

Before running Composer scripts or PHP commands that depend on platform requirements:

1. Call `get_php_project_config`.
2. Run `composer --version` if Composer is available.
3. Inspect `composer.json` platform requirements when relevant.
4. Compare Composer's PHP runtime with the PhpStorm interpreter.
5. Choose the execution path that matches project requirements.

## Command Routing

Use terminal Composer commands for deterministic output, exit codes, and logs.

Use project PHP directly or `execute_run_configuration(filePath, line)` when the script must run under PhpStorm's configured interpreter.

Treat Composer IDE actions as integration points that may be useful for a human in the IDE, but do not rely on them for machine-readable output unless current testing proves they return it.

## High-Risk Composer Actions

Classify Composer install, update, self-update, cache clearing, and dependency changes as high-risk.

Use them only with user approval, a clear target directory, before and after evidence, and verification through Composer output plus project tests.
