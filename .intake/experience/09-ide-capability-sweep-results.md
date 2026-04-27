# IDE Capability Sweep Results

## Scope

This sweep tested the callable PhpStorm MCP tools and safe IDE action discovery paths against disposable `.intake` fixtures.

It did not invoke destructive or broad actions such as Safe Delete, Code Cleanup, Composer update/install, database schema writes, database import/export, or debug-state toggles.

## Current Project Runtime

PhpStorm MCP currently reports:

- PHP language level: `8.2`
- Interpreter: `C:\wamp64\bin\php\php8.2.29\php.exe`
- Runtime: PHP `8.2.29`
- Xdebug: `3.4.4`

Global Composer reports:

- Composer `2.9.2`
- PHP runtime `8.1.26`

The Composer/PHP mismatch remains important. IDE-backed PHP execution used the project PHP 8.2 interpreter successfully, while Composer scripts used global PHP 8.1 unless explicitly routed.

## Capability Matrix

| Capability | Tested result | Skill guidance |
| --- | --- | --- |
| `get_php_project_config` | Reliable, fast, exposes interpreter, language level, extensions, Xdebug. | Run early and again before syntax/type/runtime decisions. |
| `search_file` | Reliable structured file search, including `.intake` fixtures. | Prefer for compact file coordinates and path filters. |
| `find_files_by_glob` | Initially missed fresh generated files, later found them after indexing caught up. | Use, but fall back to `search_file` or `rg` when files were just generated. |
| `find_files_by_name_keyword` | Works, but returns directories as well as files. | Treat as broad filename discovery, not a strict file-only API. |
| `search_in_files_by_text` | Reliable highlighted line results. | Good when human-readable snippets are useful. |
| `search_in_files_by_regex` | Reliable for declaration-style searches. | Good for regex search with line snippets. |
| `search_text` | Now works after indexing, with stable coordinates. | Prefer for compact machine-readable coordinates when available. |
| `get_file_problems` | Good warning/error summary, no quick fixes. | Use for pass/fail or warning inventory. |
| `get_inspections` | Richer, includes quick-fix names and families. | Use for cleanup planning and automated quick-fix loops. |
| `apply_quick_fix` | Successfully removed unused imports and inlined variables. | Apply one category at a time, then re-inspect because coordinates shift. |
| `run_inspection_kts` | Probe failed with `No inspection created after compilation`. | Treat as advanced/high-noise; only use with known-good templates or generated API/examples. |
| `reformat_file` | Works and applies IDE style. | Use only on files intended to be formatted. |
| `rename_refactoring` | Previously succeeded on simple method and interface method with implementations. | Always prefer for symbols over text replacement. |
| `open_file_in_editor` | Works. | Useful for orienting the user or setting IDE context. |
| `get_run_configurations` | No saved configs; no run points found for test scripts. | Still check first, but absence does not block file execution. |
| `execute_run_configuration` | Successfully ran PHP files by `filePath` + `line` even without saved configs/run points. | Hidden gem: prefer for PHP script/test execution when project interpreter matters. |
| `execute_terminal_command` | Runs commands in IDE terminal with clean captured output. | Use for ad hoc commands when IDE environment is useful. |
| `search_ide_actions` | Very valuable capability map. | Search actions when no direct MCP tool exists. |
| `invoke_ide_action` | Status-only for many actions; `OptimizeImports` did not modify the file in context. | Use cautiously; prefer direct MCP tools or quick fixes for machine-driven changes. |

## Strongest New Findings

### `execute_run_configuration` Can Run PHP Files Without Saved Configs

Even though `get_run_configurations` returned no saved configs and no run points for the test files, these calls succeeded:

- `.intake/large-app/tests/run.php`
- `.intake/composer-fixture/tests/smoke.php`

Both returned exit code `0` and clean output.

This is a major skill-design point. When a PHP script should run under PhpStorm's configured interpreter, `execute_run_configuration(filePath, line)` may be better than shelling out to whichever `php` is on PATH.

### Quick Fixes Beat Broad IDE Actions for Automation

`invoke_ide_action("OptimizeImports")` accepted the action but did not remove unused imports from a disposable PHP file.

`get_inspections` plus `apply_quick_fix("Unused import")` did remove the imports.

Skill implication: use IDE actions for discovery or UI workflows; use inspection quick fixes for deterministic code cleanup.

### Index Freshness Explains Earlier Search Inconsistency

Earlier, `find_files_by_glob` missed fresh generated files that `search_file` and `rg` could see. In this later sweep, after indexing caught up, `find_files_by_glob` found the same fixtures.

Skill implication: when MCP search misses fresh files, do not conclude the file does not exist. Try another MCP search surface and verify with `rg`.

### Actions Are a Capability Catalog, Not Always a Data API

Action discovery found rich capabilities:

- Find usages, show usages, usage grouping/filtering.
- Type, method, and call hierarchy.
- Debug actions and Xdebug toggles.
- Composer validate/diagnose/dry-run/update/autoload/license actions.
- Database DDL, schema compare, introspection, import/export, drop/truncate actions.
- Qodana SARIF/report actions and custom inspection entrypoints.

But invocation often returns only status and may require UI context. The skill should teach agents to search actions as a planning/discovery step, then prefer direct MCP tools or terminal commands when structured output is required.

## Composer and Database Notes

Composer:

- IDE Composer validation action was invokable but returned no result payload.
- Terminal `composer validate` remains better for machine-readable command success/failure.
- IDE PHP file execution avoided the global Composer PHP 8.1 mismatch when running the generated Composer fixture smoke test directly.

Database:

- Read-only PDO probe remains the reliable machine-readable metadata path.
- Database IDE actions were discoverable, but `DatabaseView.ForceRefresh` was not available in the current context.
- Many database actions are high-risk and should require explicit user scope and approval.

## Recommended Workflow for Future Skill

1. Start with `get_php_project_config`.
2. Discover files with `search_file`; use `find_files_by_glob` once indexing is stable.
3. Search with `search_text` for coordinates or `search_in_files_by_text` for readable snippets.
4. Use `get_file_problems` for broad diagnostics and `get_inspections` for quick-fix planning.
5. Apply quick fixes one category at a time and re-inspect after each batch.
6. Use `rename_refactoring` for all code symbol renames.
7. Use `execute_run_configuration(filePath, line)` for PHP scripts/tests when the project interpreter matters.
8. Use IDE terminal or normal shell when exact shell semantics matter.
9. Use `search_ide_actions` to discover hidden IDE capabilities.
10. Treat `invoke_ide_action` as context-sensitive and often status-only.

## Untested or Classified-Only Areas

These need explicit scope or a richer real project:

- Safe Delete on used vs unused symbols.
- Full Code Cleanup or Silent Code Cleanup.
- Find Usages and hierarchy result retrieval from IDE views.
- Debug sessions and breakpoint behavior.
- Diagram exports with artifact retrieval.
- Qodana report generation/export.
- Database DDL/schema compare/import/export/write actions.
- Composer install/update/cache actions.
