# Hidden Gem Candidates

These are PhpStorm MCP capabilities that were not central in the first tests but could materially boost agent work on large PHP projects.

## 1. IDE Action Discovery as a Capability Map

`search_ide_actions` is more than a UI helper. It exposes many PhpStorm capabilities that do not have dedicated MCP tools.

Useful action families discovered:

- `FindUsages`, `FindUsagesInFile`, `UsageView.ShowRecentFindUsages`
- `TypeHierarchy`
- `SafeDelete`
- `OptimizeImports`
- `CodeCleanup`, `SilentCodeCleanup`
- `InspectCode`, `RunInspection`, `CodeInspection.OnEditor`
- `PhpGenerateConstructor`, `PhpGenerateGetters`, `PhpGenerateGettersAndSetters`, `PhpGeneratePhpDocBlocks`
- `PhpExtractClassAction`, `PhpMakeStaticAction`
- `PhpListenDebugAction`, `PhpDebugBreakAtFirstLine`
- `ComposerValidateAction`, `ComposerDiagnoseAction`, `ComposerDryRunUpdate`, `ComposerDumpAutoloadAction`, `ComposerLicensesAction`
- Diagram export and analysis actions, including PlantUML, Mermaid, Graphviz, and centrality/cycle analysis.
- Database Explorer actions for DDL generation, SQL scripts, native import/export, and data comparison.

Skill implication: when the agent suspects PhpStorm can do something but no direct MCP tool exists, search IDE actions before falling back to terminal or manual implementation.

## 2. Find Usages and Type Hierarchy Through Actions

The current MCP schema does not expose first-class `find usages` or hierarchy tools, but action discovery found them.

Potential value:

- Validate blast radius before refactors.
- Understand inheritance-heavy code.
- Re-run recent usage searches.

Current limitation:

- `invoke_ide_action` can trigger actions, but returned structured results are not guaranteed. These may be best used interactively or for opening IDE views rather than machine-readable analysis.

## 3. Safe Delete

`SafeDelete` is an IDE action that can check usages before deletion.

Potential value:

- Safer than removing files/classes/methods with shell commands.
- Useful before pruning dead code in large projects.

Risk:

- It may require UI confirmation and can be destructive. The future skill should not invoke it automatically unless the user explicitly asks for deletion and the scope is clear.

## 4. Composer Actions

Composer-specific IDE actions are discoverable:

- Validate.
- Diagnose.
- Dry-run update.
- Install/update.
- Dump autoloader.
- List licenses.
- Manage dependencies.

Potential value:

- Composer workflows can use PhpStorm's configured PHP interpreter and Composer settings.
- Dry-run update and diagnose are useful low-risk checks before dependency changes.

Risk:

- Install/update/clear-cache actions can modify dependencies or machine state. The skill should prefer terminal commands for exact output unless the IDE configuration is the point of the task.

## 5. Diagram Export and Graph Analysis

Diagram actions include Mermaid, PlantUML, Graphviz export, cycle focus, and centrality measurement.

Potential value:

- Large-project architecture understanding.
- Dependency visualization.
- Communicating class/module relationships in reports.

Current limitation:

- Needs more testing to see whether invoked diagram actions produce files, copy to clipboard, or only manipulate the UI.

## 6. Database Explorer Actions

Database actions are visible even though no database-specific MCP tools were exposed.

Potential value:

- Generate DDL.
- Compare data.
- Run SQL scripts.
- Import/export database artifacts.

Risk:

- Database actions can affect live systems. The future skill should treat them as high-risk and require explicit user intent plus environment confirmation.

## 7. Inspection Quick Fixes as Structured Refactoring Queue

`get_inspections` returns problem descriptions and quick-fix family names. This enables a workflow:

1. Inspect a scoped file set.
2. Group findings by description/family.
3. Choose low-risk fix families.
4. Apply quick fixes one category at a time.
5. Re-run inspections and tests.

Potential value:

- Turns PhpStorm inspections into a semi-automated cleanup engine.
- Better than shell replacement because fixes are IDE-aware.

Risk:

- Some fixes are syntax- or policy-sensitive. Always refresh `get_php_project_config` first and keep scope small.

## Ranking for the Future Skill

Highest-value hidden gems:

1. `search_ide_actions` as a discovery step.
2. `get_inspections` + grouped quick-fix workflow.
3. `FindUsages` and `TypeHierarchy` actions for large refactor planning.
4. Composer diagnose/validate/dry-run actions.
5. Diagram export/actions for architecture comprehension.

Use cautiously:

- `SafeDelete`
- `CodeCleanup` and `SilentCodeCleanup`
- Composer install/update/cache actions
- Database Explorer actions

See `.intake/experience/07-hidden-gem-test-requirements.md` for the fixtures, safeguards, and success criteria needed to test these candidates properly.
