---
name: phpstorm-mcp
description: Use when Codex is working in a project opened in PhpStorm and should decide how to use PhpStorm MCP tools for project configuration, search, inspections, quick fixes, formatting, symbol refactoring, execution, HTTP Client request files, Composer or PHP checks when present, database probes, IDE action discovery, or validation. Use to route between IDE-owned semantic context and terminal tools while avoiding unsafe or low-observability IDE actions.
---

# PhpStorm MCP

Use this skill when Codex is working in a project opened in PhpStorm through the PhpStorm MCP server.

PhpStorm MCP is most useful when the IDE owns knowledge that terminal tools do not have. Examples include inspections, quick fixes, symbol-aware refactors, run configurations, formatter settings, database tooling, indexed project context, and PHP or Composer integration when the project uses them.

## When To Use

Use this skill when the task involves a PhpStorm project and any of these needs:

- Discover active PHP configuration.
- Search with IDE project awareness.
- Inspect warnings or quick-fix metadata.
- Apply scoped PhpStorm quick fixes.
- Rename code symbols semantically.
- Format files with PhpStorm settings.
- Run scripts or tests through the project runtime when PhpStorm defines one.
- Create, review, or run JetBrains HTTP Client `.http` or `.rest` request files.
- Capture response bodies or download files through approved HTTP Client request workflows.
- Compare terminal and IDE runtime behavior.
- Discover IDE capabilities through MCP actions.
- Evaluate database or IDE actions safely.

## When Not To Use

Do not use this skill for generic PHP work when PhpStorm MCP is unavailable or irrelevant.

Do not use PhpStorm MCP as a replacement for terminal tools when the task needs exact stdout, stderr, shell composition, custom arguments, custom environment variables, process control, or fresh raw file search.

Do not invoke destructive IDE actions, Composer updates, database writes, import/export actions, global cleanup, or deletion actions unless the user explicitly approves a disposable scope.

Do not run non-local, production, customer, credentialed, cookie-dependent, mutating, upload, download, response-writing, private-environment, WebSocket, GraphQL mutation, TLS-verification-disabled, or debug HTTP Client requests unless the user approves the target, method, environment, and output scope.

## Required Starting Point

Refresh live project context during the active task before making runtime, inspection, or interpreter decisions.

Use `get_php_project_config` when PHP or Composer context is relevant and the active PhpStorm MCP schema provides it. If that tool is unavailable or the project is not PHP-based, combine available IDE tools such as `get_run_configurations`, `get_project_dependencies`, `get_project_modules`, project files, and terminal probes for the active language or package manager.

Treat interpreter path, runtime version, extensions, debug settings, path format, run configurations, package-manager runtime, and inspection profiles as live project state. Do not reuse stale notes from previous sessions.

## Core Workflow

1. Refresh project configuration.
2. Check saved run configurations with `get_run_configurations` when execution is part of the task.
3. For `.http` or `.rest` request files, load `http-client-request-files.md`, inspect environment and output scope, classify risk, and discover request run points with `get_run_configurations(filePath)`.
4. Use IDE search for project-aware coordinates.
5. Use terminal search for fresh files or context windows.
6. Use `get_file_problems` for broad diagnostics.
7. Use `get_inspections` when quick-fix metadata or cleanup planning matters.
8. Apply `apply_quick_fix` one fix family at a time, then re-inspect.
9. Use `rename_refactoring` for supported code symbols instead of text replacement.
10. Use `reformat_file` only on files intended to receive PhpStorm formatting.
11. Use `execute_run_configuration(filePath, line)` for simple file execution when supported.
12. Use terminal tools when arguments, environment variables, or shell behavior matter.
13. Use `search_ide_actions` when no direct MCP tool exists.
14. Treat `invoke_ide_action` as context-sensitive unless testing proves otherwise.
15. Validate changes with IDE diagnostics first, then searches, `git status`, static analysis, or tests as the change requires.

## Tool Routing

Prefer PhpStorm MCP for semantic, IDE-owned operations. Prefer terminal tools for raw output, fresh file fallback, and shell control.

Use PhpStorm MCP for HTTP Client request-file run points and saved HTTP Request configurations. Use terminal tools such as `curl` only when exact stdout, scriptable flags, CI reproduction, or shell-level control matters more.

Load [tool-selection.md](references/tool-selection.md) for the default routing table.

Load [capability-matrix.md](references/capability-matrix.md) when deciding how much to trust a specific MCP tool or IDE action.

## Reference Loading

Load only the reference needed for the current task:

- [search-and-indexing.md](references/search-and-indexing.md) for search and index freshness.
- [inspection-and-quick-fixes.md](references/inspection-and-quick-fixes.md) for diagnostics and cleanup.
- [refactoring-and-execution.md](references/refactoring-and-execution.md) for rename and execution.
- [http-client-request-files.md](references/http-client-request-files.md) for JetBrains HTTP Client `.http` and `.rest` request files, response captures, downloads, and request execution safety.
- [composer-runtime.md](references/composer-runtime.md) only when Composer, PHP, or PHP runtime mismatch matters.
- [database-and-ide-actions.md](references/database-and-ide-actions.md) for database and action safety.

## Safety Rules

Use direct MCP tools before broad IDE actions.

Prefer `get_inspections` plus `apply_quick_fix` over `invoke_ide_action` for deterministic cleanup.

Classify database writes, schema changes, imports, exports, dependency install or update actions, delete actions, safe delete, code cleanup, Docker prune, VCS removal, debug-state toggles, non-local HTTP requests, production HTTP requests, customer HTTP requests, credentialed HTTP requests, cookie-dependent HTTP requests, mutating HTTP requests, uploads, downloads, response output writes, private-environment HTTP requests, WebSocket requests, GraphQL mutations, TLS-verification-disabled HTTP requests, and HTTP debug launches as high-risk.

For every approved high-risk action, require a disposable target in the user's project or a user-approved sandbox. Record before and after evidence, scoped verification, and user-visible reporting of what changed.

Never expose local database credentials, local PHP paths, or private project material in reusable output.

## Completion Criteria

The task is complete when the agent has used PhpStorm for IDE-owned context, used terminal tools for deterministic output, refreshed live project state before runtime decisions, validated mutations with more than one relevant signal, and reported any remaining uncertainty.
