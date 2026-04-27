# Database And IDE Actions

Use this reference for database probes, database writes, IDE action discovery, and destructive action safety.

## Database Defaults

Prefer read-only metadata probes for routine database work.

Use project-specific database tooling only after the user identifies the target and confirms the operation scope.

Do not include local database credentials in generated answers unless the user explicitly provides them for the active task.

## Read-Only Probes

Prefer deterministic read-only queries for metadata:

```sql
SELECT DATABASE();
SELECT VERSION();
SELECT CURRENT_USER();
SHOW TABLES;
```

Return machine-readable output when possible.

## Database Writes

Classify database writes as high-risk even when a disposable test database exists.

Before any database write, require:

- Explicit user approval for the exact target.
- A disposable database, schema, table, or transaction plan.
- A before-state query.
- A scoped write.
- An after-state query.
- A rollback or cleanup plan when applicable.

Never run drop, truncate, import, export, schema compare apply, or migration-like actions against non-disposable data without explicit scope and approval.

## IDE Action Discovery

Use `search_ide_actions` to discover capabilities such as usages, hierarchy, refactor actions, cleanup, Composer, database, debug, diagrams, coverage, Qodana, PHPDoc, constructors, and optimize imports.

Treat discovered actions as a capability catalog. They may require UI context, active tool windows, selected symbols, database object selection, or modal interaction.

## Action Invocation

Prefer direct MCP tools over `invoke_ide_action` for automation.

Use `invoke_ide_action` only when:

- No direct MCP tool exists.
- The action is low-risk or scoped to a disposable fixture.
- The expected output or mutation can be verified independently.
- The user has approved any destructive or broad scope.

## High-Risk Action Families

Keep these high-risk by default:

- `SafeDelete`
- `$Delete`
- `FileChooser.Delete`
- `CodeCleanup`
- `SilentCodeCleanup`
- Composer install or update actions
- Database drop, truncate, import, export, and schema alteration
- Docker delete and prune actions
- VCS remove, shelve, branch delete, and worktree delete
- Debugger breakpoint removal and debug-state toggles

## Observed Destructive Action Behavior

Delete, safe-delete, and broad cleanup actions can be unavailable, status-only, or dependent on UI context. Explicit quick fixes are the preferred mutation surface when inspection metadata is available.

Do not treat unavailable or status-only behavior as a safety guarantee. Treat it as evidence that action invocation is context-sensitive.
