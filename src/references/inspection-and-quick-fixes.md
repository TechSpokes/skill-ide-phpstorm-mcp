# Inspection And Quick Fixes

Use this reference for diagnostics, quick fixes, formatting, and cleanup.

## Diagnostics

Use `get_file_problems` for a broad warning and error summary.

Use `get_inspections` when quick-fix names, fix families, or richer inspection metadata matters.

Run IDE diagnostics before tests after most edits. They are usually cheaper and catch syntax, warning, suggestion, and formatting problems before slower behavioral checks.

Do not treat every Markdown or documentation style warning as blocking. If the repository deliberately prefers a style that PhpStorm flags, report the warning and continue with the next relevant validation signal.

Refresh project context before applying syntax-modernizing fixes. In PHP projects, use `get_php_project_config` when available. Quick-fix suitability depends on the active runtime, package constraints, inspection profile, and project settings.

## Quick-Fix Loop

Apply quick fixes one family at a time.

Use this loop:

1. Run `get_inspections` on the target file.
2. Choose one fix family, such as `Unused import`.
3. Apply `apply_quick_fix` to the scoped target.
4. Re-run `get_inspections`.
5. Repeat only if the next fix is still valid after coordinates shift.
6. Run file-level diagnostics after mutation.
7. Run tests when behavior, contracts, or integration paths could be affected.

## Broad Cleanup Actions

Prefer `get_inspections` plus `apply_quick_fix` over `invoke_ide_action` for cleanup.

Intake testing showed `CodeCleanup` and `SilentCodeCleanup` returned status without changing the scoped fixture. They may require UI scope, profile configuration, or editor context.

Classify broad cleanup as high-risk unless disposable testing proves the scope, mutation, and verification path.

## Formatting

Use `reformat_file` when the task explicitly allows formatting the target file.

Do not reformat unrelated files to make a diff look uniform.

Validate formatting edits with a diff and file problems. Run tests when behavior could be affected.
