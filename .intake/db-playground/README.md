# Database Playground

This folder contains read-only database probes for the local `phpstormtest` MariaDB database.

The default test connection is:

- Host: `localhost`
- Port: `3307`
- Database: `phpstormtest`
- User: `phpstormtest`

The probe reads environment variables first:

- `PHPSTORMTEST_DB_HOST`
- `PHPSTORMTEST_DB_PORT`
- `PHPSTORMTEST_DB_NAME`
- `PHPSTORMTEST_DB_USER`
- `PHPSTORMTEST_DB_PASSWORD`

No schema or data writes are performed by the default probe.

## Write Probe

`write_probe.php` performs controlled writes against a disposable table named `ide_mcp_probe` by default.

It performs:

- `CREATE TABLE IF NOT EXISTS`
- `ALTER TABLE` to add a `notes` column when missing
- `TRUNCATE TABLE` on only the disposable probe table
- `INSERT`
- `UPDATE`
- `SELECT`

Use only against the local test database or another explicitly disposable database.
