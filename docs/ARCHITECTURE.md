# Architecture

## Purpose

This repository packages one runtime skill: `phpstorm-mcp`.

The skill teaches agents to route PhpStorm project work between PhpStorm MCP and terminal tools. PHP-specific guidance applies only when the active project uses PHP or Composer. The architecture uses progressive disclosure so agents load only the guidance needed for the active task.

## Runtime Surface

`src/SKILL.md` is the only required entry point. It contains activation guidance, the core workflow, safety rules, reference loading guidance, and completion criteria.

`src/references/` contains focused detail:

- `tool-selection.md` for routing choices.
- `capability-matrix.md` for tested tool behavior and classifications.
- `search-and-indexing.md` for search fallback and index freshness.
- `inspection-and-quick-fixes.md` for diagnostics and cleanup.
- `refactoring-and-execution.md` for symbol rename and execution.
- `composer-runtime.md` for Composer and PHP runtime mismatch when relevant.
- `database-and-ide-actions.md` for database and action safety. Repository maintainers use `docs/MAINTENANCE-CAPABILITY-SWEEP.md` for future capability updates.

## Design Decision

The skill is a decision workflow, not a fixed command recipe.

PhpStorm MCP schemas, interpreters, Composer paths, operating systems, run configurations, and database integrations can vary. The skill therefore tells agents to refresh live project state, classify capabilities, and validate mutations instead of assuming one local setup.

## Safety Model

Direct MCP tools are preferred for semantic automation. IDE actions are treated as capability discovery unless current testing proves they are scoped, deterministic, and verifiable.

High-risk operations require explicit user approval and disposable scope. This includes database writes, Composer updates, deletion, broad cleanup, VCS removal, Docker prune, and debug-state changes.

## Maintenance Model

When PhpStorm MCP changes, run the capability sweep in `docs/MAINTENANCE-CAPABILITY-SWEEP.md`. Update references only from evidence gathered in disposable fixtures or approved real project scope.
