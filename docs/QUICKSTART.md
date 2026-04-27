# Quickstart

## Use The Skill

Load `src/SKILL.md` when working in a PhpStorm PHP project with MCP tools available.

Start each task by refreshing the active PhpStorm project configuration with `get_php_project_config`.

## Common Requests

```text
Use the PhpStorm MCP skill to inspect this PHP project and apply safe unused-import fixes.
```

```text
Use the PhpStorm MCP skill to rename this PHP method and verify the call sites.
```

```text
Use the PhpStorm MCP skill to run this PHP script through the project interpreter and compare Composer's PHP runtime.
```

## Default Workflow

1. Refresh `get_php_project_config`.
2. Use PhpStorm MCP for semantic project operations.
3. Use terminal tools for exact output and fallback verification.
4. Prefer `get_inspections` plus `apply_quick_fix` for scoped cleanup.
5. Prefer `rename_refactoring` for PHP symbols.
6. Validate changes with searches, inspections, tests, and `git status`.

## Safety Reminder

Do not invoke broad IDE actions, Composer updates, database writes, delete actions, or cleanup actions without explicit user approval and disposable scope.
