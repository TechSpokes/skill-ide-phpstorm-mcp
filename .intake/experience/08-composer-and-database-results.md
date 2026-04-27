# Composer and Database Results

## Scope

The user added a local MariaDB test database and allowed Composer usage. Tests stayed inside `.intake/`.

## Composer Fixture

Created `.intake/composer-fixture` with:

- A dependency-free `composer.json`.
- PSR-4 autoload mapping.
- A tiny `ComposerProbe` class.
- A smoke test under `tests/smoke.php`.

Commands tested:

- `composer --version`
- `composer validate --strict --no-check-publish`
- `composer dump-autoload --no-interaction`
- `composer run-script smoke`
- Explicit PHP 8.2 smoke test through `C:\wamp64\bin\php\php8.2.29\php.exe`

## Composer Findings

Composer is installed globally:

```text
Composer version 2.9.2
```

Composer itself is running on PHP `8.1.26` from `C:\wamp64\bin\php\php8.1.26\php.exe`, while PhpStorm project config currently reports PHP `8.2.29`.

This created a useful failure:

- `composer validate`: passed.
- `composer dump-autoload`: passed.
- `composer run-script smoke`: failed because Composer's script used PHP 8.1.26 and the fixture requires `php >=8.2`.
- Running the same smoke test explicitly with PHP 8.2.29 passed.

Skill implication: do not assume global Composer uses the same PHP executable as PhpStorm. For Composer scripts or test commands, compare:

- `get_php_project_config` interpreter.
- `composer --version` PHP runtime.
- `composer.json` platform requirements.

If they differ, run PHP scripts through the project interpreter or configure Composer accordingly.

## Composer IDE Actions

Action discovery previously found Composer actions for:

- Validate.
- Diagnose.
- Dry-run update.
- Dump autoload.
- Install/update.
- License listing.
- Dependency management.

Given the runtime mismatch, Composer IDE integration may be valuable if it uses PhpStorm's configured interpreter and Composer settings. This still needs direct IDE-action testing because action invocation may be UI-oriented.

## Database Fixture

Created `.intake/db-playground/probe.php`, a read-only PDO probe that reads environment variables first and falls back to the local test defaults.

The probe performs:

- `SELECT DATABASE()`
- `SELECT VERSION()`
- `SELECT CURRENT_USER()`
- `SHOW TABLES`

No schema or data writes are performed.

## Database Findings

The read-only probe connected successfully:

```json
{
  "metadata": {
    "db_name": "phpstormtest",
    "server_version": "10.3.12-MariaDB",
    "current_user_name": "phpstormtest@localhost"
  },
  "tables": [],
  "table_count": 0
}
```

The database currently has zero tables.

Later write testing created a disposable table named `ide_mcp_probe`, inserted and updated rows, and read the rows back successfully. After that test, the read-only probe reported one table. See `.intake/experience/11-database-write-results.md`.

PhpStorm inspections on the probe mostly reported spelling/no-description informational items, not connection or syntax problems.

## Database IDE Actions

Action discovery found database DDL actions including:

- Generate DDL to Query File.
- Generate DDL to Clipboard.
- Go to DDL.
- Request and Copy Original DDL.
- Apply DDL Mapping.
- Regenerate DDL files.

Potential skill value:

- Use PhpStorm database actions for schema inspection and DDL extraction when a data source is configured.
- Prefer terminal/PDO probes for deterministic, machine-readable metadata.

Safety rule:

- Treat database IDE actions as high-risk unless read-only output is guaranteed. Never run write/import/export/alter actions without explicit user approval and a test database target.

## Updated Hidden Gem

The new hidden gem is runtime mismatch detection:

1. Ask PhpStorm for the active PHP interpreter.
2. Ask Composer which PHP binary it is using.
3. Compare both against `composer.json`.
4. Choose the execution path that matches the project, not whichever `php` happens to be on PATH.
