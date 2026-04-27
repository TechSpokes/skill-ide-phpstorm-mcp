# Build Readiness Assessment

## Current State

The intake research requested in `.intake/goal.md` is complete.

The repository has enough evidence to start building the PhpStorm MCP skill from the skill base template. The collected material covers direct MCP tools, terminal comparison, larger-project behavior, Composer runtime mismatch, read-only database probing, IDE action discovery, and future maintenance sweeps.

The collected material now also covers scoped destructive IDE action probes on disposable fixtures and controlled database writes against a disposable test table.

## Source Material Available

Primary synthesis sources:

- `.intake/start-here-for-skill-build.md`
- `.intake/findings-consolidation.md`
- `.intake/intake-research-retrospective.md`
- `.intake/experience/mcp-vs-terminal-report.md`
- `.intake/experience/09-ide-capability-sweep-results.md`
- `.intake/maintenance-ide-capability-update-protocol.md`

Supporting sources:

- `.intake/experience/00-setup-and-tool-inventory.md`
- `.intake/experience/01-search-and-navigation.md`
- `.intake/experience/02-code-intelligence-and-refactoring.md`
- `.intake/experience/03-execution-and-runtime.md`
- `.intake/experience/04-untested-large-project-features.md`
- `.intake/experience/05-large-project-playground-results.md`
- `.intake/experience/06-hidden-gem-candidates.md`
- `.intake/experience/07-hidden-gem-test-requirements.md`
- `.intake/experience/08-composer-and-database-results.md`
- `.intake/experience/10-destructive-ide-action-results.md`
- `.intake/experience/11-database-write-results.md`
- `.intake/experience/12-remaining-mcp-coverage-gaps.md`
- `.intake/experience/13-execution-overrides-results.md`

Evidence fixtures:

- `.intake/app`
- `.intake/large-app`
- `.intake/action-fixture`
- `.intake/composer-fixture`
- `.intake/db-playground`
- `.intake/destructive-action-fixture`
- `.intake/execution-fixture`

## Missing Information

No blocking information is missing.

The remaining choices are optional and can use conservative defaults:

- Final skill display name.
- Whether Composer and database guidance should be advanced references.
- Whether the maintenance capability sweep prompt is released with the skill or kept in repository maintenance docs.
- Whether local database connection details remain only in `.intake`.

Use these defaults if no user input is available:

- Name the skill `phpstorm-mcp`.
- Keep Composer and database material as conditional advanced references.
- Keep concrete database credentials out of released artifacts.
- Include the maintenance sweep protocol in repository docs and optionally summarize it in a reference.

## Build Risks

The main risk is overfitting the skill to this test repository.

Mitigation: write the skill as a decision workflow. Avoid hardcoding local paths, local database credentials, or the exact current PHP version. Tell agents to refresh live project state with `get_php_project_config`.

The second risk is making IDE actions sound more deterministic than they are.

Mitigation: classify `search_ide_actions` as discovery and `invoke_ide_action` as context-sensitive. Prefer direct MCP tools and quick fixes for deterministic automation.

The destructive-action risk is treating context-gated IDE actions as safe because they returned status or unavailable messages.

Mitigation: classify delete, safe delete, cleanup, Composer update, and database write actions as high-risk unless a disposable fixture test proves safe and inspectable behavior.

The third risk is copying raw research logs into released references.

Mitigation: transform findings into durable guidance. Exclude `.intake` from release artifacts.

The process risk is that future intake research agents may wait for the user to request each exploration step.

Mitigation: use `.intake/intake-research-retrospective.md` to improve maintenance docs or the skill base template's exploration-phase guidance.

## Recommended Build Plan

1. Design `src/SKILL.md` around tool routing and safety rules.
2. Put detailed matrices and workflows into focused reference files.
3. Include a maintenance capability sweep procedure in docs or references.
4. Rewrite repository docs and `AGENTS.md` for maintenance mode.
5. Validate packaging exclusions and run repository validation.

## Readiness Decision

Proceed to skill build when the user says to start building.

Do not run another capability sweep unless the user asks for updated measurements or the MCP tool surface changes before build work begins.
