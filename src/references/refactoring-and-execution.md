# Refactoring And Execution

Use this reference for PHP symbol refactors and execution paths.

## Symbol Refactoring

Use `rename_refactoring` for PHP code symbols.

Do not use raw text replacement for code symbols unless the user explicitly asks for non-semantic text changes.

After a rename, verify with:

- MCP search for the old and new symbol.
- Terminal `rg` or equivalent search.
- `get_file_problems` on changed files.
- Relevant tests.

## Run Configuration Discovery

Call `get_run_configurations` when execution is part of the task.

Saved configurations may contain project-specific interpreter, environment, framework, Docker, WSL, SSH, or test runner settings. Absence of saved configurations does not block simple PHP file execution.

## Simple PHP File Execution

Use `execute_run_configuration(filePath, line)` for simple PHP scripts or tests when the PhpStorm project interpreter matters.

This path can work even when no saved run configuration or run point is discovered. If a fresh file cannot be accessed, force IDE awareness with search or `open_file_in_editor`, then retry.

## Arguments And Environment

Use `execute_terminal_command` or shell execution when the command needs:

- Program arguments.
- Custom environment variables.
- Custom working directory.
- Exact shell quoting behavior.
- Process composition.
- Long-running process control.

Dynamic launch overrides for arguments, working directory, and environment may be unsupported for ad hoc PHP script run configurations.

## Output Interpretation

Terminal PHP may use a different runtime than PhpStorm and may emit local warnings, such as Xdebug log messages. Treat that output as evidence about the shell path, not proof that the PhpStorm interpreter behaves the same way.
