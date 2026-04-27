# Remaining MCP Coverage Gaps

## Summary

Most directly callable PhpStorm MCP tools available in this session have now been tested at least once.

Remaining gaps are mainly due to missing real project context, UI-only action behavior, unavailable tool schema entries, or high-risk operations that should not be invoked without explicit scope.

## Direct MCP Tools Tested

These callable tools have been tested:

- `get_php_project_config`
- `get_run_configurations`
- `execute_run_configuration`
- `execute_terminal_command`
- `search_file`
- `search_text`
- `find_files_by_glob`
- `find_files_by_name_keyword`
- `search_in_files_by_text`
- `search_in_files_by_regex`
- `get_file_problems`
- `get_inspections`
- `apply_quick_fix`
- `reformat_file`
- `rename_refactoring`
- `open_file_in_editor`
- `search_ide_actions`
- `invoke_ide_action`
- `run_inspection_kts`

## Direct MCP Tools With Incomplete Coverage

### `execute_run_configuration`

Tested with `filePath` and `line` for PHP scripts. It succeeded even without saved run configurations.

Not tested:

- Existing named run configurations, because none exist.
- Dynamic launch overrides such as `programArguments`, `workingDirectory`, and `envs`, because no configuration with explicit override support was available.
- Long-running background behavior with `waitForExit=false`.
- Framework-specific test runners such as PHPUnit or Pest.

### `get_run_configurations`

Tested for project-level config discovery and file run-point discovery.

Not tested:

- Real saved PHP, PHPUnit, Composer, Docker, or remote-interpreter configurations.
- Dynamic override support metadata in a real run configuration.

### `run_inspection_kts`

Tested once and failed with:

```text
No inspection created after compilation
```

Not tested:

- Known-good Kotlin inspection templates.
- Generated PSI/API helper flows, because those tools are not exposed in the current callable schema.
- PHP-specific PSI matching beyond the failed generic probe.

Classify as advanced and unreliable until known-good examples are available.

### `invoke_ide_action`

Tested against safe and destructive action ids.

Not fully tested:

- Actions that require caret selection, active tool window state, database-object selection, or modal UI interaction.
- Actions that return useful artifacts through clipboard or IDE panels.
- Diagram export, Qodana export, coverage export, and hierarchy result retrieval.

Classify as context-sensitive and often status-only.

## MCP Capabilities Not Exposed In This Session

Older local guidance mentioned tools that are not currently present in the callable MCP schema.

Not exposed as direct tools here:

- `get_symbol_info`
- `search_symbol`
- `search_regex`
- `get_file_text_by_path`
- `create_new_file`
- `replace_text_in_file`
- `build_project`
- `get_project_dependencies`
- `get_composer_dependencies`
- `get_project_modules`
- `list_directory_tree`
- `get_all_open_file_paths`
- `generate_inspection_kts_api`
- `generate_inspection_kts_examples`
- `generate_psi_tree`
- Xdebug session start or debugger-control tools

Skill implication: do not write the skill as if these tools always exist. Mention them only as version-dependent capabilities if future MCP schemas expose them.

## IDE Action Families Discovered But Not Fully Consumed

These capabilities were discovered through `search_ide_actions`, but the current MCP action invocation path did not provide enough structured output to rely on them automatically:

- Find Usages
- Show Usages
- Type Hierarchy
- Method Hierarchy
- Call Hierarchy
- Diagram export to Mermaid, PlantUML, Graphviz, or GraphML
- Qodana report export and SARIF workflows
- Coverage report import, run, and export
- Debug listener and breakpoint workflows
- PHP code generation actions for constructors, getters, setters, and PHPDoc
- Database DDL generation and schema compare actions

Skill implication: use action discovery for planning and user guidance, but prefer direct MCP tools, terminal commands, or explicit artifact-producing workflows for automation.

## Real-Project Context Not Yet Tested

The disposable fixtures are useful but do not replace a real large project.

Still not tested:

- Real framework projects such as Symfony, Laravel, WordPress, or Magento.
- Composer projects with external dependencies.
- PHPUnit or Pest integration through saved run configurations.
- Remote interpreters, Docker interpreters, WSL, or SSH.
- Projects with vendor excluded or partially indexed.
- Projects with generated code and large result sets.
- Database data sources with real schemas, foreign keys, routines, views, and data grids.
- Xdebug stepping through a real web or CLI request.

## Destructive Or High-Risk Areas Needing Explicit User Scope

These should remain untested by default unless the user provides a disposable target and explicit approval:

- Safe Delete on real symbols.
- Full project Code Cleanup.
- Composer install, update, self-update, and cache clearing outside a fixture.
- Database drop, truncate, import, export, schema compare apply, and SQL script execution.
- Docker delete/prune actions.
- VCS remove, shelve, branch delete, and worktree delete actions.
- Debugger breakpoint removal across a real project.

## Conclusion

The current intake has enough coverage to build the skill.

The skill should include a maintenance note that PhpStorm MCP schemas vary by IDE version, plugin version, and enabled integrations. Future agents should run the capability sweep before making major skill updates, especially when new direct tools appear or when a real project exposes saved run configurations, Composer dependencies, database schemas, or debugger sessions.
