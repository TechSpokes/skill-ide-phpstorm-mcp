# Destructive IDE Action Results

## Scope

This report covers potentially destructive PhpStorm IDE actions tested through MCP.

All direct mutation tests were scoped to disposable fixtures under `.intake`. No destructive IDE action was run against release files, source skill files, `.template`, `.github`, or non-test database objects.

## Fixture

Created `.intake/destructive-action-fixture` with:

- `src/UnusedClass.php`
- `src/UsedClass.php`
- `src/CleanupTarget.php`
- `tests/run.php`

The fixture test passed before destructive-action probes:

```text
Destructive fixture tests passed.
```

## Actions Discovered

High-risk action families discovered through `search_ide_actions`:

- `SafeDelete`
- `CodeCleanup`
- `SilentCodeCleanup`
- `$Delete`
- `FileChooser.Delete`
- `ComposerUpdateAction`
- `ComposerClearCacheAction`
- `DatabaseView.DropAction`
- `DatabaseView.Alterations.TruncateTableAction`
- `DatabaseView.ImportFromSql`
- Docker delete and prune actions
- VCS remove and shelve actions
- Debugger breakpoint removal actions

Skill implication: action discovery exposes many destructive capabilities. The skill must not tell agents to invoke these broadly.

## Safe Delete

Tested actions:

- `SafeDelete` with `.intake/destructive-action-fixture/src/UnusedClass.php`
- `SafeDelete` after opening the disposable file in the editor

Result:

```text
Action 'SafeDelete' is not available in the current context
```

The file remained present.

Interpretation: `SafeDelete` likely requires caret or symbol selection context that is not represented by a file path. Through this MCP surface, it should be classified as discovery-only or UI-only unless a future test proves reliable symbol-context invocation.

## Generic Delete

Tested actions:

- `$Delete`
- `FileChooser.Delete`

Both were invoked with the disposable unused class file as context.

Result:

```text
Action '$Delete' is not available in the current context
Action 'FileChooser.Delete' is not available in the current context
```

The file remained present.

Interpretation: generic delete actions are context-sensitive and not reliable for agent automation through file path context. This is desirable from a safety perspective.

## Code Cleanup

Tested actions:

- `CodeCleanup`
- `SilentCodeCleanup`

Both were scoped to `.intake/destructive-action-fixture/src/CleanupTarget.php`.

Result:

- Both actions returned status.
- Neither action changed the file.
- The same inspection warnings remained after invocation.
- Fixture tests still passed.

Interpretation: cleanup actions may require UI scope selection, inspection-profile settings, or editor context that is not captured by file path invocation. Prefer `get_inspections` plus `apply_quick_fix` for deterministic cleanup.

## Explicit Quick Fix Mutation

Applied `Unused import` quick fixes to `.intake/destructive-action-fixture/src/CleanupTarget.php`.

Result:

- `DateTimeImmutable` import was removed.
- Re-inspection shifted coordinates.
- A second `Unused import` quick fix removed `RuntimeException`.
- Fixture tests still passed.

Interpretation: explicit quick fixes are the reliable mutation surface. Apply one fix family at a time and re-inspect after each mutation.

## Composer Destructive Actions

Tested actions against `.intake/composer-fixture/composer.json`:

- `ComposerDryRunUpdate`
- `ComposerUpdateAction`

Result:

- Both actions returned status.
- Composer fixture remained runnable.
- `composer.lock` exists in the disposable fixture.

Interpretation: Composer actions can run through MCP but return little machine-readable output. Treat them as potentially mutating. Prefer terminal Composer commands for deterministic output unless testing IDE Composer integration is the point.

## Database Destructive Actions

Tested actions without selecting database objects:

- `DatabaseView.DropAction`
- `DatabaseView.Alterations.TruncateTableAction`
- `DatabaseView.ImportFromSql`

Results:

- Drop was unavailable in the current context.
- Truncate was unavailable in the current context.
- Import returned status but the read-only database probe still reported zero tables.

Interpretation: database actions are heavily context-sensitive and high-risk. Prefer read-only PDO or terminal probes. Do not invoke database write actions unless the user provides a disposable database target and explicitly approves the exact write test.

## Safety Guidance For The Skill

Classify potentially destructive IDE actions as high-risk by default.

Use this decision order:

1. Prefer direct MCP tools for semantic operations.
2. Prefer `get_inspections` plus `apply_quick_fix` for deterministic cleanup.
3. Use `search_ide_actions` to discover destructive capabilities.
4. Do not invoke broad destructive actions without disposable scope and explicit user intent.
5. Verify every mutation with file reads, inspections, tests, and `git status`.

## Capability Classification

| Action family | Observed behavior | Skill classification |
| --- | --- | --- |
| `SafeDelete` | Unavailable with file context | UI-only until proven otherwise |
| `$Delete` | Unavailable with file context | High-risk and not recommended |
| `FileChooser.Delete` | Unavailable with file context | High-risk and not recommended |
| `CodeCleanup` | Status-only, no scoped file change | High-risk fallback |
| `SilentCodeCleanup` | Status-only, no scoped file change | High-risk fallback |
| `apply_quick_fix` | Mutated intended file predictably | Recommended scoped cleanup |
| `ComposerUpdateAction` | Accepted, fixture still passed, lock exists | High-risk and low-observability |
| `DatabaseView.DropAction` | Unavailable without DB object context | High-risk and context-gated |
| `DatabaseView.Alterations.TruncateTableAction` | Unavailable without DB object context | High-risk and context-gated |
| `DatabaseView.ImportFromSql` | Status-only, no observed DB change | High-risk and low-observability |

## Verification

After destructive-action probes:

- `.intake/destructive-action-fixture/tests/run.php` passed.
- `.intake/composer-fixture/tests/smoke.php` passed under PHP 8.2.
- `.intake/db-playground/probe.php` connected and still reported zero tables.
- `UnusedClass.php` remained present after delete and safe-delete probes.
