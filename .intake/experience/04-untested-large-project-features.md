# Untested Large-Project IDE Features

The first intake pass tested the MCP features that are meaningful on a small PHP app. Several IDE-backed capabilities remain untested or only lightly probed, and they may matter more on large projects.

## High-value features not fully tested

### Full-project inspection workflows

The sample used per-file `get_file_problems`. A later large-project test should evaluate full inspection workflows through IDE actions such as:

- `InspectCode`
- `CodeInspection.OnEditor`
- `RunInspection`
- `CodeCleanup`
- `SilentCodeCleanup`

Potential large-project value: aggregate project warnings, apply inspection profiles, run cleanup passes, and group issues by inspection type.

### Rich inspection quick fixes

`get_inspections` returned more detail than `get_file_problems`, including quick fixes such as:

- Inline unnecessary local variable.
- Add return type declaration.
- Add `void` return type.

Potential large-project value: collect fixable warning categories and apply quick fixes in batches where safe. This should be tested on a fixture with intentional warnings because the current sample app is intentionally small and clean.

### Batch code cleanup

IDE actions expose `CodeCleanup` and `SilentCodeCleanup`, but these were not executed. They may apply configured inspection-profile fixes across a scope.

Potential large-project value: faster cleanup of recurring style and inspection issues than hand-editing or shell replacement.

Risk: cleanup actions can touch many files, so the future skill should require a clean worktree or a scoped file list before invoking them.

### Run configurations and code run points

The repository has no configured run configurations, and `.intake/app/tests/run.php` produced no run points.

Potential large-project value: on real projects, run configurations often encode interpreter, environment variables, working directory, test framework, Docker/remote settings, and custom arguments. Skill guidance should always check them before inventing terminal commands.

### Custom inspections

The MCP exposes `run_inspection_kts`, and PhpStorm actions include `Qodana.NewInspectionKts`. This was not meaningfully tested.

Potential large-project value: encode project-specific checks that are too semantic for `rg` but too narrow for a permanent linter.

### IDE actions beyond search/refactor

`search_ide_actions` can discover project-specific IDE actions. Only inspection and refactor-related actions were sampled.

Potential large-project value: find and invoke built-in or plugin actions for code generation, cleanup, framework tooling, Docker support, and coverage workflows.

### Cross-file and ambiguous symbol refactors

The first test renamed one unique method and three call sites. It did not test ambiguous names, inheritance, interface implementations, traits, namespaced functions, or framework magic.

Potential large-project value: this is where IDE symbol awareness should outperform terminal replacement most strongly.

### Index freshness and excluded scopes

The classic indexed search APIs worked after creating files. The newer `search_text` helper returned no hits for the same symbol. More testing is needed on generated files, excluded directories, vendor code, and recently moved files.

Potential large-project value: agents need reliable rules for when to trust IDE indexes and when to fall back to `rg`.

## Features unavailable in the current exposed tool set

Some useful PhpStorm/JetBrains capabilities are not directly exposed by the currently available MCP tools:

- Find usages as a first-class call.
- Go to declaration/type hierarchy/call hierarchy.
- Code completion.
- Dependency/module listing, despite being mentioned in older local guidance.
- Build project as a first-class call.
- Xdebug session control.
- Coverage report inspection beyond discovering related IDE actions.

These may exist in other MCP server versions or plugins, but they were not available in this session's callable tool schema.

## Recommended next research fixture

Create a larger synthetic fixture or use a real project with:

- At least 50 PHP files.
- Duplicate method names across unrelated classes.
- Interfaces, inheritance, traits, and namespaced functions.
- Intentional inspection warnings with safe quick fixes.
- A configured PHPUnit or PHP script run configuration.
- A generated or excluded directory.

Then measure:

- MCP indexed search versus `rg` on large result sets.
- Rename safety on ambiguous symbols.
- Inspection aggregation and quick-fix workflows.
- Code cleanup blast radius.
- Run configuration reliability versus hand-built terminal commands.
