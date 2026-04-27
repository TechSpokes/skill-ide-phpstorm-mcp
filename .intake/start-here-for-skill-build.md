# Start Here For Skill Build

## Purpose

Use this guide when starting the actual skill build from the completed intake.

The intake has enough evidence to build the skill. Do not run another broad capability sweep unless the user asks for updated measurements or the MCP tool surface changes.

## First Reads

Read these files in order:

1. `.template/bootstrap/build-skill-from-intake.md`
2. `.intake/goal.md`
3. `.intake/build-readiness.md`
4. `.intake/findings-consolidation.md`
5. `.intake/experience/mcp-vs-terminal-report.md`
6. `.intake/experience/09-ide-capability-sweep-results.md`
7. `.intake/experience/10-destructive-ide-action-results.md`
8. `.intake/experience/12-remaining-mcp-coverage-gaps.md`
9. `.intake/maintenance-ide-capability-update-protocol.md`
10. `.intake/intake-research-retrospective.md`

Read supporting reports only when you need details behind a specific recommendation.

Use `.intake/intake-research-retrospective.md` only for process guidance. Do not turn conversation process notes into runtime skill instructions unless they improve future maintenance or template guidance.

## Intended Skill

Build a skill named `phpstorm-mcp` unless the user chooses another name.

The skill should help Codex agents decide when and how to use PhpStorm MCP tools while working in PhpStorm projects.

The skill should be portable across Windows, Linux, macOS, local interpreters, remote interpreters, Docker, WSL, SSH, different shells, and different PhpStorm MCP tool schemas.

Do not encode this repository's local paths, PHP versions, database credentials, or Windows-specific commands as universal guidance.

## Core Message

Use PhpStorm MCP when the IDE has semantic or configuration knowledge that terminal tools lack.

Use terminal tools when exact output, shell composition, process control, or cross-environment portability matters.

Refresh live project state before making runtime-sensitive decisions.

## Must-Carry Findings

### Project Configuration Is Live

Call `get_php_project_config` during the active task.

Do not assume PHP version, language level, Xdebug version, interpreter type, operating system, or path format.

### Search Requires Fallbacks

Use IDE search for structured coordinates and project-aware results.

Use `rg` or equivalent terminal search when files are fresh, indexing may lag, context lines are needed, or MCP results are missing.

### Inspections Drive Safe Cleanup

Use `get_file_problems` for broad diagnostics.

Use `get_inspections` when quick-fix metadata matters.

Use `apply_quick_fix` one family at a time and re-inspect after each mutation.

### Refactors Must Be Semantic

Use `rename_refactoring` for code symbols.

Verify refactors with search, inspections, and tests.

### Execution Has Multiple Paths

Use `execute_run_configuration(filePath, line)` for simple PHP script execution through the project interpreter.

Use IDE terminal or shell when arguments, environment variables, working directory, or exact shell behavior matters.

Check saved run configurations first when a real project has them.

### IDE Actions Are Not A Stable Data API

Use `search_ide_actions` to discover capabilities.

Treat `invoke_ide_action` as context-sensitive and often status-only.

Classify destructive actions as high-risk unless scoped disposable testing proves otherwise.

### Composer Runtime Can Differ

Compare PhpStorm's PHP interpreter with the PHP runtime used by Composer.

Use terminal Composer commands for deterministic output. Use project PHP directly when Composer scripts run under the wrong PHP version.

### Database Work Is High-Risk

Prefer read-only probes for routine metadata.

Require explicit user approval and disposable scope before writes.

Do not release local database credentials.

## Recommended Skill Layout

Keep `src/SKILL.md` concise.

Recommended references:

- `src/references/tool-selection.md`
- `src/references/capability-matrix.md`
- `src/references/search-and-indexing.md`
- `src/references/inspection-and-quick-fixes.md`
- `src/references/refactoring-and-execution.md`
- `src/references/composer-runtime.md`
- `src/references/database-and-ide-actions.md`
- `src/references/maintenance-capability-sweep.md`

Avoid scripts in the initial release unless a deterministic validation helper is clearly needed.

## Portability Rules

Use neutral language for paths and commands.

Prefer examples that say "use the project interpreter reported by `get_php_project_config`" instead of hardcoding a path.

Mention `rg` as the preferred terminal search when available, but allow equivalent platform search when not.

Avoid assuming:

- PowerShell.
- Bash.
- Windows paths.
- Unix paths.
- Local PHP.
- Global Composer.
- MariaDB.
- Xdebug availability.
- Saved run configurations.
- Specific MCP tools beyond the current schema.

## Release Boundary

Do not copy raw `.intake` reports or fixtures into the released skill.

Transform findings into durable guidance.

Exclude `.intake`, `.template`, `tmp`, `dist`, `.git`, and `.idea` from release artifacts.

Keep local database credentials out of release content.

## Build Steps

1. Create `.template/state/skill-design.md`.
2. Design `src/SKILL.md` around workflow, routing, safety, and validation.
3. Create focused reference files for detailed guidance.
4. Rewrite `README.md` for the generated skill.
5. Rewrite `AGENTS.md` for maintenance mode.
6. Update docs and packaging according to bootstrap instructions.
7. Run validation.
8. Wait for acceptance before removing `.template`.

## Completion Standard

The skill is ready when a future agent can load `src/SKILL.md`, know when it applies, choose between PhpStorm MCP and terminal tools, avoid unsafe IDE actions, validate edits, and maintain the skill as MCP capabilities change.
