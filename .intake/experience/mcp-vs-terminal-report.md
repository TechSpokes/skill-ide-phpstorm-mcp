# PhpStorm MCP vs Terminal Report

## Summary

The PhpStorm MCP server is most valuable when an agent needs IDE-owned knowledge: configured PHP runtime, inspections, formatting, symbol-aware refactors, run configurations, and indexed project search. Terminal tools remain better for raw reads, exact command output, shell composition, and high-speed text scans.

The future skill should not tell agents to replace terminal tools with MCP. It should teach a decision workflow: use MCP where the IDE has semantic context, and use terminal tools where the shell is simpler, more transparent, or more controllable.

## Test App

Created `.intake/app`, a small PHP 5.6-compatible app named Focus Ledger.

The app includes:

- `src/Task.php`
- `src/TaskRepository.php`
- `src/TaskService.php`
- `bootstrap.php`
- `cli.php`
- `public/index.php`
- `tests/run.php`
- `data/tasks.json`

The app supports listing active tasks, counting completed tasks, adding tasks, rendering a basic web page, and running a dependency-free test suite.

## MCP Capabilities Tested

- PHP project configuration discovery with `get_php_project_config`.
- Run configuration discovery with `get_run_configurations`.
- File discovery with `find_files_by_glob` and `find_files_by_name_keyword`.
- Indexed text and regex search with `search_in_files_by_text` and `search_in_files_by_regex`.
- Inspections with `get_file_problems`.
- Formatting with `reformat_file`.
- Symbol rename with `rename_refactoring`.
- IDE terminal execution with `execute_terminal_command`.

## Terminal Capabilities Tested

- File inventory with `rg --files`.
- Text search with `rg`.
- Runtime execution with PHP CLI.
- Syntax linting with `php -l`.
- Timing a representative search with `Measure-Command`.

## Observed Strengths

MCP strengths:

- Revealed PhpStorm's configured language level and interpreter in one call.
- Returned line-numbered indexed search results with highlighted matches.
- Found filename and glob matches while respecting IDE project awareness.
- Ran PhpStorm inspections, which terminal PHP lint cannot reproduce.
- Applied IDE formatting rules without requiring the agent to infer them.
- Renamed a PHP method and updated three call sites safely.
- Ran a test command through the IDE terminal and returned exit code plus concise output.

Terminal strengths:

- `rg` found freshly created text immediately and measured at about 55 ms for a representative search.
- Shell commands were transparent and easy to compose.
- PHP CLI linting covered every PHP file quickly.
- Direct command output is preferable when exact stdout/stderr behavior matters.

## Project Configuration Update

Initial MCP discovery reported PhpStorm language level `5.6.0` with PHP `8.1.26`. The project configuration was later changed and now reports language level `8.2` with PHP `8.2.29` and Xdebug `3.4.4`.

This changes the interpretation of syntax-modernizing quick fixes. Return types and null coalescing suggestions are now consistent with the active project language level, but the skill should still instruct agents to refresh project config before applying such fixes.

## Observed Issues

- PhpStorm project configuration changed during the research session, from language level `5.6.0` with PHP `8.1.26` to language level `8.2` with PHP `8.2.29`. Skill guidance must treat project config as live state.
- `search_text` returned no matches for a freshly created symbol under `.intake/app`, while `search_in_files_by_text` worked. Skill guidance should prefer the older PhpStorm search tools unless future testing proves `search_text` reliable in this context.
- Direct PHP CLI execution emitted repeated Xdebug log warnings because `c:/wamp64/logs/xdebug.log` could not be opened. MCP IDE terminal execution returned cleaner output for the same test command.
- No IDE run configurations existed, so `execute_run_configuration` could not be meaningfully tested beyond discovery.

## Large-Project Gaps

Several IDE features were not fully tested because the sample app is intentionally small:

- Full-project inspection and cleanup actions.
- Batch quick-fix workflows through `get_inspections` and `apply_quick_fix`.
- Run configurations with framework-specific environment.
- Custom `inspection.kts` checks.
- Ambiguous cross-file refactors involving interfaces, inheritance, traits, and duplicate symbol names.
- Index freshness, excluded scopes, generated files, and large result sets.

See `.intake/experience/04-untested-large-project-features.md` for the detailed gap list and a suggested next fixture.

An additional playground pass created `.intake/large-app` and tested a larger semantic rename, richer inspections, quick fixes, and large-fixture search behavior. See `.intake/experience/05-large-project-playground-results.md`.

Hidden-gem candidates were also cataloged after probing IDE action discovery for Find Usages, Type Hierarchy, Safe Delete, Composer, diagrams, and database actions. See `.intake/experience/06-hidden-gem-candidates.md`.

Composer and database probes were added after the local `phpstormtest` MariaDB data source became available. See `.intake/experience/08-composer-and-database-results.md`.

An expanded IDE capability sweep then tested the direct MCP surface and safe action invocation patterns. See `.intake/experience/09-ide-capability-sweep-results.md`.

Scoped destructive IDE action probes were run against disposable fixtures. See `.intake/experience/10-destructive-ide-action-results.md`.

A maintenance-oriented protocol now describes how future agents should recreate a safe IDE capability lab and produce skill update recommendations. See `.intake/maintenance-ide-capability-update-protocol.md`.

## Recommended Skill Guidance

The generated skill should teach this decision matrix:

| Task | Prefer MCP | Prefer terminal |
| --- | --- | --- |
| Discover PHP interpreter, language level, extensions, Xdebug | Yes | No |
| Find files by name or glob inside IDE project boundaries | Yes | Sometimes |
| Search text with line-numbered project results | Yes | Use `rg` for raw speed or context windows |
| Inspect PHP warnings/errors | Yes | Terminal can only lint syntax unless extra tools exist |
| Format files according to PhpStorm settings | Yes | No |
| Rename symbols | Yes | No, except trivial non-code text |
| Run existing IDE configurations | Yes | No |
| Run ad hoc shell commands | Sometimes | Yes |
| Need exact stdout/stderr and process control | No | Yes |

## Suggested Skill Shape

`src/SKILL.md` should stay concise and focus on tool choice, required parameters, and validation loops. Detailed comparisons and examples can live in `src/references/` during the later build phase.

Likely reference files:

- `references/tool-selection.md`
- `references/phpstorm-mcp-capabilities.md`
- `references/terminal-comparison.md`
- `references/testing-notes.md`

No deterministic scripts appear necessary yet. The core value is procedural guidance for selecting and sequencing MCP tools.

## Verification Performed

- `php .intake/app/tests/run.php`: passed.
- `php -l` over all `.intake/app/**/*.php`: no syntax errors.
- PhpStorm `get_file_problems` on main PHP files: no errors.
- PhpStorm symbol rename from `listOpenTasks` to `listActiveTasks`: succeeded and tests passed afterward.
- After the config change, both fixtures passed under `C:\wamp64\bin\php\php8.2.29\php.exe`.
