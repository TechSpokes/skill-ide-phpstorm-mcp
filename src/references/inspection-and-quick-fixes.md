# Inspection And Quick Fixes

Use this reference for diagnostics, quick fixes, formatting, and cleanup.

## Diagnostics

Use `get_file_problems` for a broad warning and error summary.

Use `get_inspections` when quick-fix names, fix families, or richer inspection metadata matters.

Refresh `get_php_project_config` before applying syntax-modernizing fixes. PHP language level can change during a session, and quick-fix suitability depends on the active project settings.

## Quick-Fix Loop

Apply quick fixes one family at a time.

Use this loop:

1. Run `get_inspections` on the target file.
2. Choose one fix family, such as `Unused import`.
3. Apply `apply_quick_fix` to the scoped target.
4. Re-run `get_inspections`.
5. Repeat only if the next fix is still valid after coordinates shift.
6. Run tests or file-level diagnostics after mutation.

## Broad Cleanup Actions

Prefer `get_inspections` plus `apply_quick_fix` over `invoke_ide_action` for cleanup.

Intake testing showed `CodeCleanup` and `SilentCodeCleanup` returned status without changing the scoped fixture. They may require UI scope, profile configuration, or editor context.

Classify broad cleanup as high-risk unless disposable testing proves the scope, mutation, and verification path.

## Formatting

Use `reformat_file` when the task explicitly allows formatting the target file.

Do not reformat unrelated files to make a diff look uniform.

Validate formatting edits with a diff, file problems, and tests when behavior could be affected.
