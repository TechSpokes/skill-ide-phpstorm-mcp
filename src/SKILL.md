---
name: phpstorm-mcp
description: Use when Codex is working in a PhpStorm PHP project and should decide how to use PhpStorm MCP tools for project configuration, search, inspections, quick fixes, formatting, symbol refactoring, PHP execution, Composer runtime checks, database probes, IDE action discovery, or validation. Use to route between IDE-owned semantic context and terminal tools while avoiding unsafe or low-observability IDE actions.
---

# PhpStorm MCP

Use this skill to work effectively in PhpStorm PHP projects through the PhpStorm MCP server.

PhpStorm MCP is most useful when the IDE owns knowledge that terminal tools do not have: configured PHP interpreter, language level, inspections, quick fixes, symbol-aware refactors, run configurations, formatter settings, Composer integration, database tooling, and indexed project context.

## When To Use

Use this skill when the task involves a PhpStorm project and any of these needs:

- Discover active PHP configuration.
- Search with IDE project awareness.
- Inspect PHP warnings or quick-fix metadata.
- Apply scoped PhpStorm quick fixes.
- Rename PHP symbols semantically.
- Format files with PhpStorm settings.
- Run PHP scripts or tests through the project interpreter.
- Compare Composer, PHP, terminal, and IDE runtime behavior.
- Discover IDE capabilities through MCP actions.
- Evaluate database or IDE actions safely.

## When Not To Use

Do not use this skill for generic PHP work when PhpStorm MCP is unavailable or irrelevant.

Do not use PhpStorm MCP as a replacement for terminal tools when the task requires exact stdout, stderr, shell composition, custom arguments, custom environment variables, long-running process control, or raw file search over freshly generated files.

Do not invoke destructive IDE actions, Composer updates, database writes, import/export actions, global cleanup, or deletion actions unless the user explicitly approves a disposable scope.

## Required Starting Point

Call `get_php_project_config` during the active task before making runtime-sensitive, syntax-sensitive, or interpreter-sensitive decisions.

Treat PHP language level, interpreter path, runtime version, extensions, Xdebug, path format, run configurations, and Composer runtime as live state. Do not reuse stale notes from previous sessions.

## Core Workflow

1. Refresh project configuration with `get_php_project_config`.
2. Check saved run configurations with `get_run_configurations` when execution is part of the task.
3. Use IDE search for project-aware coordinates and terminal search for fresh files or context windows.
4. Use `get_file_problems` for broad diagnostics.
5. Use `get_inspections` when quick-fix metadata or cleanup planning matters.
6. Apply `apply_quick_fix` one fix family at a time, then re-inspect because coordinates can shift.
7. Use `rename_refactoring` for PHP code symbols instead of text replacement.
8. Use `reformat_file` only on files intended to receive PhpStorm formatting.
9. Use `execute_run_configuration(filePath, line)` for simple PHP file execution when the project interpreter matters.
10. Use terminal tools or `execute_terminal_command` when arguments, environment variables, working directory, or shell behavior matter.
11. Use `search_ide_actions` to discover hidden IDE capabilities when no direct MCP tool exists.
12. Treat `invoke_ide_action` as context-sensitive and often status-only unless current disposable testing proves otherwise.
13. Validate changes with MCP search, terminal search, inspections, tests, and `git status`.

## Tool Routing

Prefer PhpStorm MCP for semantic, IDE-owned operations. Prefer terminal tools for raw output, fresh file fallback, and shell control.

Load [tool-selection.md](references/tool-selection.md) for the default routing table.

Load [capability-matrix.md](references/capability-matrix.md) when deciding how much to trust a specific MCP tool or IDE action.

## Reference Loading

Load only the reference needed for the current task:

- [search-and-indexing.md](references/search-and-indexing.md) for file search, text search, regex search, and index freshness.
- [inspection-and-quick-fixes.md](references/inspection-and-quick-fixes.md) for diagnostics, quick fixes, formatting, and cleanup.
- [refactoring-and-execution.md](references/refactoring-and-execution.md) for symbol rename, run configurations, terminal execution, and execution overrides.
- [composer-runtime.md](references/composer-runtime.md) for Composer validation, Composer scripts, PHP runtime mismatch, and project interpreter routing.
- [database-and-ide-actions.md](references/database-and-ide-actions.md) for database probes, database writes, destructive actions, and action discovery.

## Safety Rules

Use direct MCP tools before broad IDE actions.

Prefer `get_inspections` plus `apply_quick_fix` over `invoke_ide_action` for deterministic cleanup.

Classify database writes, schema changes, imports, exports, Composer install or update, delete actions, safe delete, code cleanup, Docker prune, VCS removal, and debug-state toggles as high-risk.

For every approved high-risk action, require a disposable target in the user's project or a user-approved sandbox, before and after evidence, scoped verification, and user-visible reporting of what changed.

Never expose local database credentials, local PHP paths, or private project material in reusable output.

## Completion Criteria

The task is complete when the agent has used the IDE where it adds semantic value, used terminal tools where they add determinism, refreshed live project state before runtime decisions, validated any mutation through more than one signal, and reported remaining uncertainty.
