# Maintenance Capability Sweep

Use this repository maintenance procedure when updating the skill after PhpStorm, the MCP server, PHP runtimes, Composer, or IDE integrations change.

This procedure is not runtime guidance for installed skill users. It exists so maintainers can update `src/SKILL.md` and `src/references/` from evidence.

## Test Area

Use a disposable directory:

- Use `tmp/ide-capability-lab` for local experiments.
- Store any evidence that should survive cleanup in a maintainer-reviewed document under `docs/`.
- Use `.intake/` only for human-provided maintenance material that needs later review.

Do not include disposable fixtures in release artifacts.

## Required Sweep

1. Refresh `get_php_project_config`.
2. Record PHP language level, interpreter, runtime, extensions, and Xdebug.
3. Record `get_run_configurations`.
4. Compare Composer's PHP runtime with PhpStorm's interpreter.
5. Test file discovery, text search, regex search, and terminal `rg`.
6. Test `get_file_problems`, `get_inspections`, `apply_quick_fix`, and `reformat_file`.
7. Test `rename_refactoring` on a disposable symbol with implementations and call sites.
8. Test `execute_run_configuration`, `execute_terminal_command`, and shell execution.
9. Use `search_ide_actions` to catalog action families.
10. Invoke only low-risk actions on disposable fixtures.
11. Run read-only database probes only when a disposable or approved data source exists.
12. Compare findings against `src/SKILL.md` and relevant references.

## Prohibited By Default

Do not invoke these during a routine sweep:

- Safe delete or generic delete.
- Full code cleanup.
- Composer install, update, self-update, or cache clearing.
- Database writes, imports, exports, truncates, drops, or schema changes.
- Docker delete or prune.
- VCS removal or branch deletion.
- Debug-state toggles or breakpoint removal across a real project.

Use those only after explicit user approval of the exact disposable scope.

## Report Format

Produce a report with these sections:

- Runtime snapshot.
- Capability matrix.
- New or changed capabilities.
- Regressions or unreliable tools.
- Safety findings.
- Recommended skill changes.
- Suggested patch plan.
- Verification commands run.

Do not edit `src/SKILL.md` or references until the user approves broad or risky guidance changes.
