# Code Intelligence and Refactoring Findings

## Scenario

Validate the PHP app, format files, and rename a service method across call sites.

## MCP inspections

`get_file_problems` reported no errors for these files:

- `.intake/app/src/Task.php`
- `.intake/app/src/TaskRepository.php`
- `.intake/app/src/TaskService.php`
- `.intake/app/cli.php`
- `.intake/app/public/index.php`
- `.intake/app/tests/run.php`

This is a clear MCP-only advantage. Terminal `php -l` can catch syntax errors, but it cannot provide PhpStorm inspections, quick fixes, or project-language-level diagnostics.

## MCP formatting

`reformat_file` returned `ok` for:

- `.intake/app/public/index.php`
- `.intake/app/src/TaskService.php`

This applies the IDE's code style without requiring the agent to infer local formatting rules.

## MCP symbol rename

`rename_refactoring` renamed `TaskService::listOpenTasks` to `TaskService::listActiveTasks` and updated three usages:

- `.intake/app/cli.php`
- `.intake/app/public/index.php`
- `.intake/app/tests/run.php`

Tests passed after the rename. This is the strongest observed MCP advantage because a text replacement can be unsafe when method names overlap, inheritance is involved, or references are indirect.

## Terminal comparison

Terminal linting succeeded for all PHP files with `php -l`, but it also emitted repeated Xdebug log warnings because the CLI runtime could not open `c:/wamp64/logs/xdebug.log`. The IDE terminal test command did not show that warning in its returned output.

After the project config changed, both sample fixtures also passed under `C:\wamp64\bin\php\php8.2.29\php.exe`. The Xdebug log warning still appeared in direct shell output.

## Efficiency judgment

Use MCP for inspections, formatting, and symbol-aware changes. Use terminal linting as a cheap runtime sanity check, but do not treat it as a substitute for IDE inspections.
