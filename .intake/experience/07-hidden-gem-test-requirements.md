# Hidden Gem Test Requirements

Testing the hidden-gem IDE features properly needs more than the current synthetic fixtures. Most of these features depend on project configuration, IDE UI state, or external systems.

## Global Preconditions

- Use a disposable branch or a clean worktree snapshot.
- Keep a before/after diff for every IDE action.
- Scope actions to `.intake/` or another disposable fixture unless the user explicitly approves a real project target.
- Refresh `get_php_project_config` immediately before syntax, type, Composer, debug, or run-configuration tests.
- Run tests and inspections after each action category, not only at the end.

## Find Usages and Type Hierarchy

Needed fixture:

- Interfaces with multiple implementations.
- Abstract classes and subclasses.
- Traits.
- Duplicate method names in unrelated classes.
- At least one call through an interface type and one concrete call.

Success criteria:

- Action can be invoked with the correct editor context.
- Agent can recover enough result information from the IDE view or follow-up searches to plan a refactor.
- Results help identify blast radius better than `rg`.

Current gap:

- The available action invocation may open an IDE view without returning machine-readable usages.

## Safe Delete

Needed fixture:

- One unused class, method, and file.
- One used class, method, and file that should be rejected or warned about.
- Tests proving behavior before and after deletion.

Success criteria:

- Safe delete blocks or warns for used symbols.
- Safe delete removes unused symbols without leaving broken references.
- Diff is limited to the intended disposable fixture.

Safety rule:

- Do not run on non-disposable project files without explicit user approval.

## Code Cleanup and Silent Code Cleanup

Needed fixture:

- Multiple files with low-risk cleanup findings.
- Multiple files with findings that should not be auto-applied.
- A baseline diff and test suite.

Success criteria:

- Cleanup scope can be constrained.
- Applied changes match expected inspection families.
- Tests still pass.
- Agent can summarize the diff by category.

Safety rule:

- Never run global cleanup on the whole repository as an exploratory test.

## Composer Actions

Needed fixture:

- A disposable `composer.json`.
- Optional `composer.lock`.
- At least one intentionally invalid Composer field for validate/diagnose.
- Network-independent checks first.

Success criteria:

- Validate and diagnose return useful results.
- Dry-run update does not mutate files.
- Dump autoload mutates only expected generated files when intentionally tested.

Safety rule:

- Avoid install/update/clear-cache unless the user approves dependency and machine-state changes.

## Debug Actions

Needed fixture:

- A PHP script that can pause at a breakpoint or first line.
- Known Xdebug config.
- A run configuration or repeatable terminal command.

Success criteria:

- Debug listening state can be detected or intentionally toggled.
- Break-at-first-line behavior can be observed.
- The agent can stop or leave the IDE in a known debug state.

Current gap:

- The visible MCP schema has no first-class Xdebug session control, so this may remain UI-driven.

## Diagram Export and Graph Analysis

Needed fixture:

- A small class graph with known relationships.
- A target export format, preferably Mermaid or PlantUML.
- A known output location or clipboard capture method.

Success criteria:

- Diagram action produces a retrievable artifact or visible output.
- Exported graph contains expected classes and relationships.
- Cycle or centrality actions can be interpreted by the agent.

Current gap:

- Action discovery found diagram actions, but output retrieval is unclear.

## Database Explorer Actions

Needed fixture:

- Disposable local SQLite database or isolated test database.
- No production credentials.
- Known schema and sample data.
- Explicit user approval before any action that writes, imports, exports, or runs SQL.

Success criteria:

- DDL generation and data comparison produce retrievable artifacts.
- Read-only SQL script execution is scoped to the disposable database.
- No live environment is touched.

Safety rule:

- Treat database actions as high-risk by default.

## PHP Code Generation Actions

Needed fixture:

- Classes with private properties but missing constructors/getters/PHPDoc.
- Expected generated methods.
- Formatting baseline.

Success criteria:

- Constructor/getter/PHPDoc generation works from editor context.
- Generated code respects current PHP language level and project style.
- Diff is predictable and scoped.

Current gap:

- Generation actions likely require caret/editor context and may be hard to automate without opening files and selecting symbols.

## Recommended Next Test Order

1. Find Usages and Type Hierarchy on `.intake/large-app`.
2. PHP code generation in a disposable class.
3. Safe Delete on deliberately unused symbols.
4. Scoped Code Cleanup on disposable warning files.
5. Composer validate/diagnose on a disposable Composer fixture.
6. Diagram export if output retrieval can be confirmed.
7. Debug and database tests only with explicit user-selected scope.
