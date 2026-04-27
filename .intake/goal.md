# PhpStorm MCP Skill Intake Goal

## One-Command Entry Point

This file is the stable starting point for a fresh agent or a brand new fork of the skill base template.

Use:

```powershell
codex "start from C:\Users\serge\PhpstormProjects\skill-ide-phpstorm-mcp\.intake\goal.md"
```

The agent must assume it has no prior conversation context. Read this file first, then read `AGENTS.md` and `.template/bootstrap/build-skill-from-intake.md`.

## User Intent

Build a standalone Codex skill that helps agents work more effectively in PhpStorm projects through the PhpStorm MCP server.

The skill should teach agents when to use PhpStorm MCP tools instead of terminal tools, when terminal tools remain better, how to validate changes through the IDE, and how to avoid unsafe IDE actions.

The original motivation is agent efficiency. PhpStorm has IDE-owned context that terminal tools do not have: configured PHP runtime, language level, inspections, quick fixes, symbol-aware refactors, run configurations, IDE terminal behavior, Composer integration, and database tooling.

## Critical Phase Rule

Do not start the skill build phase until the intake research phase is complete.

If the research artifacts listed in `Research Completion Gate` are missing, stale, or incomplete, complete the research phase first. Do not ask the user to guide the research unless a local resource is unavailable or an action would affect non-disposable data.

If the artifacts already exist and pass the completion gate, summarize readiness and proceed to skill design under the bootstrap workflow.

## Research Completion Gate

The intake research phase is complete only when these artifacts exist:

- `.intake/experience/mcp-vs-terminal-report.md`
- `.intake/experience/09-ide-capability-sweep-results.md`
- `.intake/experience/10-destructive-ide-action-results.md`
- `.intake/experience/11-database-write-results.md`
- `.intake/experience/12-remaining-mcp-coverage-gaps.md`
- `.intake/experience/13-execution-overrides-results.md`
- `.intake/maintenance-ide-capability-update-protocol.md`
- `.intake/findings-consolidation.md`
- `.intake/start-here-for-skill-build.md`
- `.intake/intake-research-retrospective.md`
- `.intake/build-readiness.md`

If any artifact is missing, create it before building the skill.

## Research Phase Procedure

### Step 1: Connect To PhpStorm MCP

Read `.intake/.mcp.json` and verify the PhpStorm MCP tools are available.

Call `get_php_project_config` and record:

- PHP language level.
- PHP interpreter path.
- PHP runtime version.
- Loaded extensions.
- Xdebug version.

Call `get_run_configurations` and record available run configurations.

### Step 2: Create Disposable Fixtures

Create all fixtures inside `.intake`.

Create a small PHP app in `.intake/app` with:

- Classes.
- A service layer.
- A CLI entry point.
- A web entry point.
- JSON or simple storage.
- A no-dependency test runner.

Create a larger PHP fixture in `.intake/large-app` with:

- Interfaces.
- Multiple implementations.
- Inheritance.
- Traits.
- Duplicate method names.
- Intentional inspection warnings.
- A no-dependency test runner.

Create an action fixture in `.intake/action-fixture` for quick fixes and IDE actions.

Create a Composer fixture in `.intake/composer-fixture` when Composer is installed.

Create a database playground in `.intake/db-playground` only for read-only probes.

### Step 3: Compare MCP With Terminal Tools

Compare MCP and terminal tools for:

- File discovery.
- Text search.
- Regex search.
- PHP inspections.
- Quick fixes.
- Formatting.
- Symbol rename refactoring.
- PHP script execution.
- IDE terminal execution.
- Composer validation and scripts.
- Read-only database metadata.

Use `rg` as the terminal baseline for file and text search.

Use the PhpStorm project interpreter from `get_php_project_config` when PHP runtime consistency matters.

### Step 4: Test Safe And Destructive IDE Actions

Test potentially destructive IDE actions only against disposable `.intake` fixtures.

Allowed destructive-action tests:

- `SafeDelete` on a known unused disposable file or symbol.
- `SafeDelete` on a known used disposable symbol to see whether it blocks or opens UI.
- `CodeCleanup` or `SilentCodeCleanup` on a disposable warning fixture.
- Composer destructive actions only when scoped to `.intake/composer-fixture`.
- Database destructive actions only when the user explicitly approves a disposable database write test.

Do not run global cleanup, repository-wide deletion, Composer update/install, database writes, import, export, drop, truncate, or debug-state toggles against real project files.

For every destructive-action test:

- Record the exact fixture.
- Record the action id.
- Capture before and after file state with `git diff` or file reads.
- Run relevant tests and inspections afterward.
- Record whether the action mutated files, opened UI, returned status only, or was unavailable.

### Step 5: Discover Hidden IDE Capabilities

Use `search_ide_actions` for:

- `usage`
- `hierarchy`
- `refactor`
- `inspection`
- `cleanup`
- `composer`
- `database`
- `debug`
- `diagram`
- `coverage`
- `qodana`
- `phpdoc`
- `constructor`
- `optimize imports`
- `safe delete`

Classify each action family as recommended, fallback, discovery-only, UI-only, unreliable, unavailable, or high-risk.

### Step 6: Document Research

Write experience notes under `.intake/experience`.

Required reports:

- `mcp-vs-terminal-report.md`
- `09-ide-capability-sweep-results.md`
- `10-destructive-ide-action-results.md`
- `11-database-write-results.md`
- `12-remaining-mcp-coverage-gaps.md`
- `13-execution-overrides-results.md`

Write or update `.intake/maintenance-ide-capability-update-protocol.md`.

Write or update `.intake/intake-research-retrospective.md` so future maintainers can see how the research mode should have worked without human steering.

Write `.intake/build-readiness.md` after the research gate passes.

## Current Research Summary

The current repository already contains completed research artifacts. A fresh fork may not.

When artifacts exist, use the following tested findings as source material.

## Tested Findings For The Skill

### Live Project Configuration

Always call `get_php_project_config` during the active task. Project configuration changed during research from PHP language level `5.6.0` with PHP `8.1.26` to language level `8.2` with PHP `8.2.29`.

Do not rely on stale notes when deciding whether to apply syntax-modernizing quick fixes.

### Search Tool Selection

Use `search_file` and `search_text` for compact structured results. Use legacy `search_in_files_by_text` and `search_in_files_by_regex` when highlighted line snippets are useful.

When indexed search misses fresh files, verify with another MCP search tool and then `rg`. Treat this as possible index freshness, not proof that a file does not exist.

### Inspections And Quick Fixes

Use `get_file_problems` for broad diagnostics. Use `get_inspections` when quick-fix metadata matters.

Apply quick fixes one category at a time and re-inspect after each batch because coordinates can shift.

Prefer `get_inspections` plus `apply_quick_fix` over broad actions such as `OptimizeImports` for deterministic automation.

### Refactoring

Always use `rename_refactoring` for code symbols. It handled both a simple method rename and an interface method rename with multiple implementations and a polymorphic call site.

Validate refactors with MCP search, `rg`, inspections, and tests.

### Execution

`execute_run_configuration(filePath, line)` can run PHP files successfully even when no saved run configuration or run point is discovered.

Prefer this path when the PhpStorm project interpreter matters. Use shell or IDE terminal when exact shell semantics matter.

### Composer

Global Composer may run under a different PHP version than PhpStorm.

During research, Composer used PHP `8.1.26` while PhpStorm used PHP `8.2.29`. Composer validation and dump-autoload worked, but a Composer script failed until run explicitly with the project PHP interpreter.

### Database

Database IDE actions are discoverable but high-risk. Prefer read-only PDO or terminal probes for machine-readable metadata.

Do not include local database credentials in released skill artifacts. Use generic placeholders unless the user explicitly requests otherwise.

Controlled database writes were tested against a disposable table named `ide_mcp_probe`. Create, alter, truncate of the probe table, insert, update, schema read, and data read all worked.

The skill should still classify database writes as high-risk. Require explicit user approval, disposable scope, and before/after verification for write operations.

### IDE Actions

Use `search_ide_actions` as a capability catalog. It found actions for usages, hierarchy, refactor, inspections, cleanup, Composer, database, debug, diagrams, coverage, Qodana, PHPDoc, constructors, and imports.

Treat `invoke_ide_action` as context-sensitive and often status-only. Do not assume it returns structured data or mutates files.

### Destructive IDE Actions

Test potentially destructive actions only on disposable fixtures.

Prefer direct MCP tools, explicit quick fixes, and file-scoped commands over broad IDE cleanup actions. Classify broad actions as high-risk unless fixture testing proves they are safely scoped and inspectable.

## Expected Skill Product

Create `src/SKILL.md` as the canonical skill entry point.

Keep `src/SKILL.md` concise. It should teach:

- When the skill applies.
- The standard PhpStorm MCP workflow.
- Tool routing between MCP and terminal tools.
- Safety rules.
- Validation loops.
- Fallback behavior when MCP results are stale, unavailable, or UI-only.

Move detailed guidance into references.

Recommended reference files:

- `src/references/tool-selection.md`
- `src/references/capability-matrix.md`
- `src/references/inspection-workflows.md`
- `src/references/refactoring-and-execution.md`
- `src/references/composer-and-runtime.md`
- `src/references/database-and-ide-actions.md`
- `src/references/maintenance-capability-sweep.md`

No deterministic runtime scripts are required for the initial skill. The value is procedural guidance, not reusable code.

## Repository Build Instructions

When building the skill from this intake:

1. Read bootstrap instructions required by `AGENTS.md`.
2. Inventory `.intake/` and summarize source quality.
3. Create `.template/state/skill-design.md` while bootstrap mode is active.
4. Build the skill product under `src/`.
5. Rewrite repository docs for the generated skill.
6. Rewrite `AGENTS.md` for maintenance mode.
7. Update packaging and release docs.
8. Run repository validation commands.
9. Remove `.template/` only after the generated skill is accepted.

Do not copy raw `.intake` files into release artifacts. Transform the durable findings into skill guidance.

## Maintenance Requirement

The finished repository should preserve a maintenance workflow for future IDE capability updates.

Use `.intake/maintenance-ide-capability-update-protocol.md` as the source for either:

- A released reference file if users of the skill should run capability sweeps.
- Repository maintenance documentation if only maintainers should run capability sweeps.

The future maintenance prompt should let an agent safely run an IDE capability update sweep and propose skill improvements without modifying skill files until the user approves.

## Completion Criteria For The Skill Build

The skill build is complete when:

- `src/SKILL.md` contains concise, actionable PhpStorm MCP workflow guidance.
- References preserve the tested tool-selection rules and safety constraints.
- Repository docs describe the generated skill, not the bootstrap template.
- `AGENTS.md` describes skill maintenance mode.
- Packaging excludes `.intake`, `.template`, `tmp`, `dist`, `.git`, and `.idea`.
- Validation passes.
- Future agents can maintain the skill without reading this conversation.
