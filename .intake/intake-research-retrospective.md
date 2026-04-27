# Intake Research Retrospective

## Purpose

This document records how the research phase was guided by the human and what a future agent should do differently when started from `.intake/goal.md` with no prior context.

Use this as source material if the skill base template is updated with stronger guidance for an intake research mode.

## Conversation Direction By Human

The human repeatedly expanded the research scope after the initial request.

Human-directed corrections and expansions included:

- Asked whether large-project IDE features had not been tested.
- Clarified that `.intake` was a safe playground for broader experiments.
- Noted that PhpStorm project configuration changed during the session.
- Asked for hidden-gem IDE capabilities.
- Asked what was needed to test hidden gems properly.
- Provided a local MariaDB test database and allowed Composer usage.
- Asked for a more extensive capability sweep.
- Asked for future maintenance-agent guidance and a single prompt.
- Clarified that `goal.md` must work for a blank-context agent in a brand new fork.
- Pointed out that potentially destructive IDE calls still needed testing.
- Asked to test database writes, table changes, and reads.
- Asked for remaining MCP coverage gaps.
- Asked for a final consolidation and start-here guide.

The human's guidance turned a narrow sample-app comparison into a broader intake research program.

## What The Agent Should Have Done From The Beginning

The agent should have treated the original prompt as a research-phase specification, not just a request to build one small sample app.

The agent should have created a research plan with explicit phases:

- MCP tool inventory.
- Safe fixture creation.
- Small-project comparison.
- Large-project simulation.
- Hidden capability discovery.
- Destructive-action testing in disposable scope.
- Composer and runtime testing.
- Database testing, initially read-only.
- Execution-path testing.
- Maintenance-mode sweep protocol.
- Build readiness assessment.

The agent should have defined a completion gate before starting any experiments.

The agent should have asked fewer follow-up questions and made conservative assumptions because the user had already designated `.intake` as the source and test area.

The agent should have documented from the start that raw intake and fixtures are evidence, not release content.

The agent should have built `goal.md` as a zero-context command entry point immediately, rather than first rewriting it as if research had already been completed.

## Missed Early Tests

The first research pass did not test several areas that should have been in the initial plan:

- Large-project behavior.
- Multiple MCP search APIs and index freshness.
- `get_inspections` versus `get_file_problems`.
- Quick-fix automation.
- Interface and implementation rename behavior.
- `execute_run_configuration(filePath, line)`.
- Arguments, environment variables, and working directory behavior.
- Composer runtime mismatch.
- Database actions and database writes.
- Destructive IDE actions in disposable scope.
- IDE action discovery as a capability catalog.
- Remaining schema gaps and tools not exposed in the current MCP server.

These were eventually tested because the human kept steering the research.

## Better Intake Research Mode

The skill base template should guide agents to create an intake research mode when the user asks for exploration before skill building.

Intake research mode should require:

- A research plan before fixture creation.
- A clear "do not build the skill yet" gate.
- A list of capability categories to explore.
- A disposable playground directory.
- Safe destructive-action rules.
- A source-quality and coverage log.
- A final build-readiness decision.
- A start-here guide for the later skill-building agent.

The mode should tell agents to explore the domain actively instead of waiting for the user to ask each follow-up question.

## Recommended Template Guidance

Add a section to the skill base template for exploratory intake.

Suggested guidance:

```text
If `.intake/goal.md` asks for research before skill building, enter intake research mode. Do not start `src/SKILL.md` until the research completion gate passes.

Create a plan that covers tool inventory, fixtures, safe comparisons, edge cases, destructive operations in disposable scope, maintenance implications, and build readiness.

Use `.intake` as the only research workspace unless the user explicitly provides another disposable target. Document each experiment under `.intake/experience`.

When a tool or capability is high-risk, first discover and classify it. Invoke it only against disposable fixtures or with explicit user approval.

End research mode by writing a consolidation, a build-readiness assessment, and a start-here guide for the skill-building agent.
```

## Acceptance Criteria For Future Intake Research

A future agent should not need the human to ask for each expansion.

The research phase is complete when:

- The available tool surface is inventoried.
- Safe and risky capabilities are both classified.
- Representative fixtures exist.
- Direct tool behavior is compared with fallback tools.
- Environment assumptions are identified as live state.
- Remaining gaps are documented.
- The build agent has a concise start-here guide.

## Implication For This Skill

The final PhpStorm MCP skill should include maintenance guidance for future capability sweeps.

The broader skill base template may also need a generic exploration-phase pattern so agents can transform vague "research this first" intake into a complete evidence base without incremental human steering.
