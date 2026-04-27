# Tool Selection

Use this reference to choose between PhpStorm MCP and terminal tools.

## Default Rule

Use PhpStorm MCP when the IDE has semantic or configuration knowledge. Use terminal tools when raw execution, exact output, process control, or fresh-file visibility matters more.

## Routing Choices

Use `get_php_project_config` to discover the PHP runtime only when PHP or Composer context matters. Fall back to run configurations, project files, or language-specific terminal probes.

Use `get_project_dependencies` to discover dependencies. Fall back to the project package manager or manifest.

Use `get_project_modules` to discover modules. Fall back to project search.

Use `search_file` to find project files by path. Fall back to `find_files_by_glob`, then `rg --files`.

Use `search_text` for compact text coordinates. Fall back to `search_in_files_by_text`, then `rg`.

Use `search_in_files_by_regex` for regex search. Fall back to `rg`.

Use `get_file_problems` for broad diagnostics. Fall back to language-specific lint, static analyzers, and tests.

Use `get_inspections` for quick-fix planning. Fall back to manual edits after inspection.

Use `apply_quick_fix` for scoped cleanup. Fall back to manual edits.

Use `rename_refactoring` for supported code symbols. Avoid raw text replacement for code symbols.

Use `reformat_file` to format one intended file. Fall back to the project formatter only when known.

Use `execute_run_configuration(filePath, line)` for simple file execution when the active MCP schema supports it. Fall back to IDE terminal or shell.

Use `execute_terminal_command` or shell execution when arguments or environment matter. Fall back to saved run configurations when supported.

Use `search_ide_actions` to discover IDE capabilities. Fall back to the IDE UI or official docs.

Avoid broad IDE actions by default. Use them only with disposable scope.

## Decision Questions

Ask these questions before choosing a tool:

- Which PhpStorm MCP tools are actually available in this IDE and client session?
- Is the active project actually PHP-based, mixed-language, or unrelated to PHP?
- Does PhpStorm know something the terminal does not know?
- Does the task need exact shell behavior or machine-readable stdout?
- Were files created recently enough that IDE indexing may lag?
- Is the operation semantic, such as a code symbol rename?
- Can the action mutate files, dependencies, database state, or IDE state?
- Is there a deterministic validation path after the action?

## Validation Pattern

Start validation with IDE diagnostics because they are usually cheaper than tests and can catch syntax, inspection, warning, and suggestion-level problems quickly.

Use `get_file_problems` on changed files first (to get a deeper analysis immediately use parameter `errorsOnly` with `false` value). Use `get_inspections` when quick-fix metadata, warnings, or suggestions matter.

Review the diagnostic before deciding whether to fix it. Project-accepted documentation style warnings, such as code formatting preferences, can be reported as intentionally ignored.

Then add the next signal that matches the risk of the change:

- MCP search plus `rg`.
- IDE diagnostics plus `git status`.
- IDE diagnostics plus language-specific lint or static analysis.
- IDE diagnostics plus targeted tests.
- IDE diagnostics plus broader tests for behavior changes.
- Package-manager command exit code plus project script execution.
