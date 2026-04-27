# Capability Matrix

Use this reference when deciding how much to trust a PhpStorm MCP tool.

## Direct Tools

| Capability | Observed behavior | Guidance |
| --- | --- | --- |
| `get_php_project_config` | Reliable runtime and language-level snapshot. | Run early and before runtime-sensitive decisions. |
| `get_run_configurations` | Useful discovery even when no saved configurations exist. | Check first; absence does not block file execution. |
| `execute_run_configuration` | Ran PHP files by `filePath` and `line` without saved configs. | Prefer for simple PHP execution through project interpreter. |
| `execute_terminal_command` | Captured IDE terminal output cleanly. | Use when IDE terminal environment matters. |
| `search_file` | Reliable structured path search. | Prefer for compact file coordinates. |
| `search_text` | Good compact coordinates after indexing was current. | Use when available; verify fresh-file misses. |
| `find_files_by_glob` | Can miss very fresh files until indexing catches up. | Use after indexing stabilizes or with fallback. |
| `find_files_by_name_keyword` | Returns broad filename and directory matches. | Treat as broad discovery. |
| `search_in_files_by_text` | Reliable highlighted line snippets. | Use when readable snippets matter. |
| `search_in_files_by_regex` | Reliable declaration-style regex search. | Use for regex with line snippets. |
| `get_file_problems` | Broad warning and error summary. | Use for diagnostics inventory. |
| `get_inspections` | Includes quick-fix families and metadata. | Use before automated quick fixes. |
| `apply_quick_fix` | Predictable scoped mutations in fixtures. | Apply one family at a time and re-inspect. |
| `reformat_file` | Applies IDE formatter. | Use only on intended files. |
| `rename_refactoring` | Updated declarations, implementations, and call sites. | Prefer for PHP symbols. |
| `open_file_in_editor` | Sets IDE context. | Use for user orientation or index awareness. |
| `search_ide_actions` | Valuable capability catalog. | Use for discovery when direct tools are absent. |
| `invoke_ide_action` | Often status-only and context-sensitive. | Avoid for deterministic automation. |
| `run_inspection_kts` | Failed without a known-good inspection template. | Treat as advanced and unreliable. |

## Schema Variability

PhpStorm MCP schemas vary by IDE version, plugin version, enabled integrations, project type, and host environment.

Do not assume unavailable tools exist. If a direct tool appears in a future schema, test it against a disposable fixture before promoting it in the skill.

## Classification Terms

Recommended means the tool is expected to produce useful, scoped, repeatable results. Verify against the active project when environment details matter.

Fallback means the tool is useful after the preferred path fails or when its output shape better fits the task.

Discovery-only means the tool helps find capabilities but should not be treated as an automation surface.

High-risk means the tool can mutate broad file, dependency, database, VCS, Docker, debug, or IDE state.
