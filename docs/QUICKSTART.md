# Quickstart

## Use The Skill

Load `src/SKILL.md` when working in a project opened in PhpStorm with MCP tools available.

Start each task by refreshing the active PhpStorm project context. Use `get_php_project_config` when PHP or Composer context matters and the MCP schema provides it.

## Common Requests

```text
Use the PhpStorm MCP skill to inspect this project and apply low-risk unused-import fixes.
```

```text
Use the PhpStorm MCP skill to rename this PHP method and verify the call sites.
```

```text
Use the PhpStorm MCP skill to run this PHP script through the project interpreter and compare Composer's PHP runtime.
```

```text
Use the PhpStorm MCP skill in this frontend project to inspect warnings and validate the changed files before running tests.
```

## Default Workflow

1. Refresh active project context.
2. Use PhpStorm MCP for semantic project operations.
3. Use terminal tools for exact output and fallback verification.
4. Prefer `get_inspections` plus `apply_quick_fix` for scoped cleanup.
5. Prefer `rename_refactoring` for supported code symbols.
6. Validate changes with IDE diagnostics first, then searches, `git status`, static analysis, or tests as the change requires.

## Safety Reminder

Do not invoke broad IDE actions, dependency updates, database writes, delete actions, or cleanup actions without explicit user approval and disposable scope.
