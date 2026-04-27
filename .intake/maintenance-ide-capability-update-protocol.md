# IDE Capability Update Protocol

## Intent Analysis

The user wants future skill maintenance agents to have a repeatable way to discover whether PhpStorm MCP capabilities changed, became more reliable, or exposed new useful workflows.

The desired outcome is not just another test report. The desired outcome is a maintenance loop that lets an agent safely create an IDE testing environment inside the skill repository, exercise the IDE capability surface, compare findings against the existing skill guidance, and propose concrete skill updates.

The user also wants a single prompt that can be given to a future agent, such as: "see IDE capabilities update and suggest skill updates/improvements." That prompt should carry enough constraints and acceptance criteria that the agent can execute without private context from this bootstrap session.

## Goal Stack

### Global Goal

Keep the PhpStorm MCP skill accurate as PhpStorm, the MCP server, Composer, PHP runtimes, and local IDE integrations evolve.

### Communication Goal

Give maintenance agents a stable testing protocol that turns IDE capability drift into evidence-backed skill changes.

### Task Goal

Create disposable fixtures, run safe capability probes, classify risky or UI-only capabilities, and produce a proposed skill update plan.

## Required Environment

Use a repository clone with the skill source and a writable disposable test area.

Require PhpStorm to be open with the repository loaded. Require the PhpStorm MCP server to be reachable before testing IDE features.

Use a disposable branch or verify that all pending changes are intentional. Never run broad cleanup, deletion, Composer update, or database write actions against real project files during capability discovery.

## Recommended Test Area

Create or reuse a disposable directory such as `.intake/ide-capability-lab` during bootstrap, or `tmp/ide-capability-lab` after the repository enters maintenance mode.

Keep these fixture categories separate:

- PHP syntax and inspections.
- Symbol refactoring.
- Search and indexing.
- Composer runtime.
- Database read-only probes.
- IDE action invocation.
- Run configuration and execution.

Do not include disposable fixtures in release artifacts.

## Fixture Requirements

### PHP Fixture

Create a small PHP project with interfaces, implementations, inheritance, traits, duplicate method names, unused imports, unnecessary locals, missing return types, and at least one test script.

Use this fixture to test:

- `search_file`
- `find_files_by_glob`
- `find_files_by_name_keyword`
- `search_text`
- `search_in_files_by_text`
- `search_in_files_by_regex`
- `get_file_problems`
- `get_inspections`
- `apply_quick_fix`
- `reformat_file`
- `rename_refactoring`
- `execute_run_configuration`

### Composer Fixture

Create a dependency-free `composer.json` with PSR-4 autoloading, a smoke test, and a PHP version constraint that matches the active PhpStorm project interpreter.

Use this fixture to test:

- Global `composer --version`
- `composer validate`
- `composer dump-autoload`
- Composer script execution
- Difference between Composer's PHP runtime and PhpStorm's configured PHP interpreter
- Composer IDE actions discovered by `search_ide_actions`

### Database Fixture

Use only a disposable database. For this project, the known local test database is:

```text
jdbc:mariadb://localhost:3307/phpstormtest
user: phpstormtest
password: phpstormtest
```

Start with read-only probes:

- `SELECT DATABASE()`
- `SELECT VERSION()`
- `SELECT CURRENT_USER()`
- `SHOW TABLES`

Do not create, alter, drop, truncate, import, export, or run write queries unless the user explicitly approves that scope.

### IDE Action Fixture

Create small files that make action behavior visible, such as unused imports for Optimize Imports and private fields for PHP generation actions.

Use these fixtures to test whether `invoke_ide_action` produces a real file change, only opens a UI panel, or returns unavailable in the current context.

## Capability Sweep Procedure

### Step 1: Refresh Live Project State

Call `get_php_project_config` at the start of every sweep.

Record:

- PHP language level.
- PHP interpreter path.
- PHP runtime version.
- Loaded extensions.
- Xdebug version.
- Composer runtime from `composer --version`.
- Available run configurations from `get_run_configurations`.

### Step 2: Test Search and Indexing

Run multiple search surfaces against the same known symbols.

Compare:

- `search_file`
- `find_files_by_glob`
- `find_files_by_name_keyword`
- `search_text`
- `search_in_files_by_text`
- `search_in_files_by_regex`
- `rg`

Record whether missed results appear after waiting for indexing. Treat fresh-file misses as index freshness evidence, not proof that files are absent.

### Step 3: Test Inspections and Quick Fixes

Run `get_file_problems` for broad diagnostics. Run `get_inspections` when quick-fix metadata matters.

Apply at most one quick-fix family at a time. Re-run `get_inspections` after each fix because line and column coordinates can shift.

Record which quick fixes are deterministic and which are syntax-policy-sensitive.

### Step 4: Test Symbol Refactoring

Use `rename_refactoring` on a disposable symbol with multiple implementations and call sites.

Verify with:

- MCP search for old and new names.
- Terminal `rg`.
- Fixture tests.
- `get_file_problems` on changed files.

Never use raw text replacement as the comparison method for code symbols unless the task is explicitly non-semantic text.

### Step 5: Test Execution Paths

Compare direct shell execution, IDE terminal execution, and `execute_run_configuration(filePath, line)`.

Record:

- Exit code.
- Output clarity.
- PHP interpreter used.
- Whether Xdebug warnings appear.
- Whether saved run configurations exist.
- Whether unsaved file execution works.

Prefer `execute_run_configuration(filePath, line)` when the project interpreter matters.

### Step 6: Discover IDE Actions

Use `search_ide_actions` across these query families:

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

Classify each action family as direct-use, discovery-only, UI-only, high-risk, or unavailable in context.

### Step 7: Probe Low-Risk Actions

Invoke only low-risk actions on disposable fixtures.

Record whether the action:

- Mutates the intended file.
- Opens a UI surface.
- Returns structured data.
- Returns only status.
- Is unavailable in context.

Prefer direct MCP tools and `apply_quick_fix` over broad actions when deterministic file changes are needed.

### Step 8: Test Composer Safely

Run network-independent Composer checks first.

Compare global Composer's PHP runtime with PhpStorm's PHP interpreter. If they differ, test the same PHP script through the project interpreter.

Avoid install, update, self-update, clear-cache, or dependency changes unless the user explicitly approves them.

### Step 9: Test Database Safely

Use read-only metadata probes first.

Discover database IDE actions, but do not invoke write-capable actions during routine capability sweeps.

Prefer PDO or terminal probes for machine-readable metadata. Treat database IDE actions as high-risk unless the action is proven read-only and scoped to a disposable database.

### Step 10: Compare Against Skill Guidance

Open the current `src/SKILL.md` and relevant `src/references/` files.

Compare current guidance against the sweep results. Identify:

- New tools or actions that should be added.
- Existing recommendations that are now wrong.
- Tool order changes.
- New safety rules.
- New examples or fixtures that should become references.
- Capabilities that should remain excluded or warning-only.

## Watch List

Monitor these areas during every future sweep:

- PhpStorm MCP tool schema changes.
- Search behavior on fresh files and excluded folders.
- `execute_run_configuration(filePath, line)` behavior.
- Composer PHP runtime mismatch.
- Xdebug warnings in shell output.
- `invoke_ide_action` result quality.
- `get_inspections` quick-fix family names.
- `run_inspection_kts` reliability.
- Database action availability and risk.
- Qodana and diagram output retrieval.

## Output Requirements

Produce a report with these sections:

- Runtime snapshot.
- Capability matrix.
- New or changed capabilities.
- Regressions or unreliable tools.
- Safety findings.
- Recommended skill changes.
- Suggested patch plan.
- Verification commands run.

Do not update the skill automatically unless the user asks for implementation. Propose changes first when the sweep finds broad or risky guidance changes.

## Single Prompt for Future Maintenance Agents

Use this prompt when asking a future agent to update the skill from current IDE capabilities:

```text
Use the PhpStorm MCP skill repository in this workspace. Your task is to run a safe IDE capability update sweep and suggest skill improvements.

First read the repository's maintenance instructions, `src/SKILL.md`, and any reference files related to PhpStorm MCP tool selection. Then create or reuse disposable fixtures under `.intake/ide-capability-lab` if the repository is still in bootstrap mode, or `tmp/ide-capability-lab` if it is in maintenance mode.

Refresh the live PhpStorm project state with `get_php_project_config`. Compare PhpStorm's PHP interpreter with global Composer's PHP runtime. Discover saved run configurations. Exercise safe MCP tools for search, inspections, quick fixes, formatting, symbol rename, file execution, IDE terminal execution, Composer validation, and read-only database metadata. Use `search_ide_actions` to catalog usages, hierarchy, refactor, inspection, cleanup, Composer, database, debug, diagram, coverage, Qodana, PHPDoc, constructor, and optimize-import actions.

Do not invoke destructive or broad actions such as Safe Delete, Code Cleanup, Composer install/update, database writes, database import/export, debug-state toggles, or schema changes unless the user explicitly approves the exact scope. Prefer disposable fixtures and keep a before/after diff for every mutation.

Document what changed since the skill guidance was last written. Classify each capability as recommended, fallback, discovery-only, unreliable, unavailable, or high-risk. Produce a report with a capability matrix, safety findings, recommended skill updates, and a concrete patch plan. Do not edit `src/SKILL.md` or references until the user approves the proposed updates.
```

## Acceptance Criteria

- The sweep can run without modifying release artifacts.
- Every mutation happens in a disposable fixture.
- The report distinguishes evidence from inference.
- The proposed skill changes reference tested behavior.
- High-risk IDE actions are discovered but not invoked by default.
- The final patch plan can be reviewed before skill files are edited.
