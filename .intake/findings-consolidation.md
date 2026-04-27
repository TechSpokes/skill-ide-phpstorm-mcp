# Findings Consolidation

## Overall Conclusion

PhpStorm MCP is worth a dedicated skill because it gives Codex access to IDE-owned context that terminal tools cannot reliably reproduce.

The skill should not replace terminal workflows. It should teach routing: use MCP for semantic IDE operations and live project configuration, and use terminal tools for exact output, shell composition, and broad fallback verification.

## Tested Strengths

PhpStorm MCP is strong for:

- PHP project configuration discovery.
- IDE-indexed search after indexing is current.
- File coordinates and compact search results.
- PhpStorm inspections and quick-fix metadata.
- Applying explicit quick fixes.
- IDE formatting.
- Symbol-aware rename refactoring.
- Simple PHP script execution through the project interpreter.
- IDE terminal execution with clean captured output.
- IDE action discovery.

Terminal tools are strong for:

- Raw file discovery and search.
- Fresh files before IDE indexing catches up.
- Exact stdout and stderr.
- Arguments, environment variables, and working directory control.
- Composer command output.
- Database probes with deterministic JSON output.

## Tool Routing Summary

| Task | Preferred path | Fallback |
| --- | --- | --- |
| Get PHP runtime and language level | `get_php_project_config` | Shell `php -v` only as secondary evidence |
| Find files by path | `search_file` | `find_files_by_glob`, then `rg --files` |
| Search text with coordinates | `search_text` | `search_in_files_by_text`, then `rg` |
| Search regex | `search_in_files_by_regex` | `rg` |
| Broad diagnostics | `get_file_problems` | PHP lint and project tests |
| Quick-fix planning | `get_inspections` | Manual edit after inspection |
| Apply deterministic cleanup | `apply_quick_fix` | Manual edit |
| Rename symbols | `rename_refactoring` | Do not use text replacement for code symbols |
| Format a file | `reformat_file` | Project formatter, if known |
| Run simple PHP file | `execute_run_configuration(filePath, line)` | IDE terminal or shell |
| Run with args or env | `execute_terminal_command` or shell | Saved run config with supported overrides |
| Discover hidden IDE features | `search_ide_actions` | IDE UI or docs |
| Invoke broad IDE action | Avoid by default | Use only with disposable scope |

## Safety Findings

Destructive IDE actions are context-sensitive and high-risk.

Observed behavior:

- `SafeDelete` was unavailable with file context.
- Generic delete actions were unavailable with file context.
- `CodeCleanup` and `SilentCodeCleanup` returned status but did not mutate the scoped file.
- `ComposerUpdateAction` accepted execution against a fixture and produced Composer artifacts.
- Database drop and truncate actions were unavailable without object context.
- Database import returned status but did not change the test DB in the observed run.
- Explicit quick fixes produced predictable scoped mutations.

Skill guidance should prefer explicit MCP operations over broad IDE actions.

## Runtime Findings

Project configuration can change during a session.

Observed change:

- Initial PhpStorm config: PHP language level `5.6.0`, PHP `8.1.26`.
- Later PhpStorm config: PHP language level `8.2`, PHP `8.2.29`.

Composer can use a different PHP runtime than PhpStorm.

Observed mismatch:

- PhpStorm PHP: `8.2.29`
- Global Composer PHP: `8.1.26`

The skill must tell agents to refresh runtime state rather than assume machine details.

## Database Findings

Read-only metadata probes worked against the local test MariaDB database.

Controlled writes also worked against a disposable table:

- Create table.
- Alter table.
- Truncate only the probe table.
- Insert rows.
- Update row.
- Read schema.
- Read data.

The skill should classify database writes as high-risk and require explicit approval plus disposable scope.

## Remaining Gaps

No blocking gap remains for skill building.

Remaining untested areas require real project context:

- Saved run configurations with override support.
- PHPUnit, Pest, or framework-specific run configs.
- Remote, Docker, WSL, or SSH interpreters.
- Qodana artifact export.
- Coverage workflows.
- Diagram artifact retrieval.
- Debug sessions and breakpoint control.
- Real database schemas and data grids.
- Real framework projects with dependencies.

## Skill Design Decision

Build the skill as a decision workflow with references.

Do not build it as a fixed command recipe. The target environment may be Windows, Linux, macOS, local, remote, containerized, or using a different MCP schema.
