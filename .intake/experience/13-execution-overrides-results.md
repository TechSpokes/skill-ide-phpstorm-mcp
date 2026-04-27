# Execution Overrides Results

## Scope

This report covers the last practical execution gap: arguments, working directory, and environment variables across IDE execution paths.

## Fixture

Created `.intake/execution-fixture/argv_env_probe.php`.

The script prints:

- Current working directory.
- `argv`.
- `IDE_MCP_PROBE` environment variable.
- PHP version.

## IDE Terminal Result

`execute_terminal_command` successfully passed arguments and an environment variable through the shell.

Observed:

- `cwd`: repository root.
- `argv`: script path, `alpha`, `two words`.
- `IDE_MCP_PROBE`: `from_execute_terminal_command`.
- PHP version: `8.2.29`.

## Shell Result

Direct shell execution also passed arguments and an environment variable.

Observed:

- `cwd`: repository root.
- `argv`: script path, `alpha`, `two words`.
- `IDE_MCP_PROBE`: `from_shell`.
- PHP version: `8.2.29`.

Direct shell output continued to include the local Xdebug log warning.

## `execute_run_configuration` Result

The first execution attempt returned:

```text
Cannot access file: .intake/execution-fixture/argv_env_probe.php
```

After opening the file and confirming indexed search could see it, the file became executable through `execute_run_configuration`.

Attempting dynamic launch overrides returned:

```text
Run configuration 'argv_env_probe.php' of type 'PHP Script' doesn't support dynamic launch overrides (programArguments, workingDirectory, envs).
```

Executing without overrides succeeded.

Observed:

- `cwd`: script directory, `.intake/execution-fixture`.
- `argv`: absolute script path only.
- `IDE_MCP_PROBE`: `null`.
- PHP version: `8.2.29`.

## Skill Implications

Use `execute_run_configuration(filePath, line)` for simple PHP script execution when the project interpreter matters.

Use `execute_terminal_command` or shell execution when arguments, custom working directory, environment variables, or exact shell semantics matter.

If `execute_run_configuration` cannot access a newly created file, force discovery through `search_file`, `find_files_by_glob`, or `open_file_in_editor`, then retry. Treat this as another index freshness or IDE file-awareness issue.
