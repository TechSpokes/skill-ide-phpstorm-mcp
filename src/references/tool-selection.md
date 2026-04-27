# Tool Selection

Use this reference to choose between PhpStorm MCP and terminal tools.

## Default Rule

Use PhpStorm MCP when the IDE has semantic or configuration knowledge. Use terminal tools when raw execution, exact output, process control, or fresh-file visibility matters more.

## Routing Table

| Task | Preferred path | Fallback |
| --- | --- | --- |
| Discover PHP runtime and language level | `get_php_project_config` | Shell `php -v` as secondary evidence |
| Find project files by path | `search_file` | `find_files_by_glob`, then `rg --files` |
| Search text with compact coordinates | `search_text` | `search_in_files_by_text`, then `rg` |
| Search regex | `search_in_files_by_regex` | `rg` |
| Broad diagnostics | `get_file_problems` | PHP lint and project tests |
| Quick-fix planning | `get_inspections` | Manual edit after inspection |
| Scoped cleanup | `apply_quick_fix` | Manual edit |
| Rename PHP symbols | `rename_refactoring` | Avoid raw text replacement for code symbols |
| Format one file | `reformat_file` | Project formatter only when known |
| Run a simple PHP file | `execute_run_configuration(filePath, line)` | IDE terminal or shell |
| Run with arguments or environment | `execute_terminal_command` or shell | Saved run config when supported |
| Discover IDE capabilities | `search_ide_actions` | IDE UI or official docs |
| Invoke broad IDE actions | Avoid by default | Use only with disposable scope |

## Decision Questions

Ask these questions before choosing a tool:

- Does PhpStorm know something the terminal does not know?
- Does the task need exact shell behavior or machine-readable stdout?
- Were files created recently enough that IDE indexing may lag?
- Is the operation semantic, such as a code symbol rename?
- Can the action mutate files, dependencies, database state, or IDE state?
- Is there a deterministic validation path after the action?

## Validation Pattern

Use at least two validation signals after any mutation.

Good signal pairs include:

- MCP search plus `rg`.
- `get_file_problems` plus tests.
- File reads plus `git status`.
- Composer command exit code plus project PHP script execution.
