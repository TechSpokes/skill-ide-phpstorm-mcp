# Large Project Playground Results

## Fixture

Created `.intake/large-app`, a larger synthetic PHP fixture with:

- Interfaces: `TaskHandler`, `Reporter`.
- Inheritance: `AbstractHandler` with concrete handler subclasses.
- Trait usage: `LogsActivity`.
- Duplicate method names: several classes implemented `handle`, later renamed to `process`.
- Services and reporters with intentional inspection opportunities.
- A no-dependency test runner at `.intake/large-app/tests/run.php`.

## Runtime validation

The large fixture test passed before and after refactors:

```text
Large fixture tests passed.
```

PHP linting reported no syntax errors for all fixture PHP files. Direct PHP CLI linting continued to emit the existing Xdebug log warning.

## Indexed search behavior

Terminal `rg` saw the fixture immediately and measured about 75 ms for a representative multi-pattern search.

MCP behavior varied by tool:

- `search_file` found all large fixture PHP files.
- `search_in_files_by_text` and `search_in_files_by_regex` found symbols and declarations.
- `find_files_by_glob` returned no files for the same fixture.
- `find_files_by_name_keyword` returned no result for `EmailTaskHandler`.

Skill implication: teach a fallback ladder. If one MCP file-search tool misses fresh or generated files, try another MCP search surface and then fall back to `rg`.

## Semantic rename test

Renamed `TaskHandler::handle` to `TaskHandler::process` through `rename_refactoring`.

PhpStorm updated:

- The interface method.
- Three implementing handler methods.
- The polymorphic call site in `DispatchService`.

The tool reported only `1 usages`, but actual edits covered the semantic implementation set. The operation took about 23 seconds, much slower than text replacement, but it handled a case where text replacement is risky.

Skill implication: for code symbols, prefer MCP rename even when it is slower. Validate afterward with `rg`, inspections, and tests.

## Inspection and quick-fix behavior

`get_inspections` exposed richer findings than `get_file_problems`, including:

- Unused local variables.
- Unread private properties.
- Missing return type declarations.
- `isset` ternary expressions replaceable with `??`.
- Quick fixes with family names.

Applied safe quick fixes:

- Inlined a redundant `$output` variable in `JsonReporter`.
- Inlined a redundant `$subject` variable in `EmailTaskHandler`.

Both quick fixes preserved passing tests.

The project configuration changed after the first pass. PhpStorm now reports language level `8.2` with PHP `8.2.29`, so syntax-modernizing quick fixes such as `??` and return type additions are now compatible with the active project configuration.

Skill implication: do not bake a language-level assumption into the skill. Always call `get_php_project_config` immediately before accepting syntax or type quick fixes, because the IDE configuration can change during the research/build session.

## IDE action discovery

`search_ide_actions` found useful large-project actions:

- `InspectCode`
- `CodeInspection.OnEditor`
- `RunInspection`
- `CodeCleanup`
- `SilentCodeCleanup`
- Coverage actions such as `Coverage`, `ImportCoverage`, and `GenerateCoverageReport`

These actions were discovered but not invoked globally. Code cleanup can touch many files, so the future skill should require a scoped path list and a before/after diff review before using it.

## Run configurations

No run configurations or run points were discovered for the synthetic test runner.

Skill implication: keep the rule "check IDE run configurations first, then fall back to terminal." This repository cannot validate the high-value run configuration path because no configuration exists.

## Updated Skill Design Implications

The future skill should emphasize:

- Use `get_php_project_config` before changing PHP syntax.
- Use `get_inspections` when quick-fix detail matters; use `get_file_problems` for lighter pass/fail checks.
- Use `rename_refactoring` for symbols and validate the result with tests and search.
- Treat IDE cleanup actions as high-blast-radius operations.
- Prefer terminal `rg` for immediate raw search and MCP indexed search for line-numbered project-aware results.
- Include a fallback path when MCP search surfaces disagree.
