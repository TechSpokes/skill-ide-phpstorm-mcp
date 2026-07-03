# Release Process Implementation Plan

> For agentic workers: REQUIRED SUB-SKILL: Use `superpowers:subagent-driven-development` or `superpowers:executing-plans` to implement this plan task by task. Steps use checkbox syntax for tracking.

## Goal

Make `docs/RELEASING.md` the single source for how changes land, how `main` is protected, how CI verifies the skill package, and how tagged releases create draft GitHub releases.

## Architecture

This phase is documentation-first. It expands the release process document, then removes duplicated release workflow detail from agent and contributor instructions where a pointer is enough.

## Repository Context

This repository packages one runtime skill, `phpstorm-mcp`. Preserve the maintenance split: `docs/RELEASING.md` governs repository change flow and release cutting, while `src/SKILL.md` remains the runtime skill entry point for installed agent hosts.

When local judgment is needed, choose the option that makes release rules easier to verify, avoids duplicated instructions, and keeps release artifacts limited to runtime skill files and plugin manifests.

## Tech Stack

- Markdown documentation under `docs/`, repository root, and `.github/`.
- GitHub Actions workflows already present under `.github/workflows/`.
- Repository validation through `npm run validate`.

## Preconditions

- Read `AGENTS.md`, `.github/instructions/markdown.instructions.md`, `docs/ROADMAP.md`, and this plan before editing.
- Run `git status --short` and preserve unrelated user changes.
- Apply `docs/plans/workflow-release-drift/workflow-release-drift.plan.md` first unless the CI smoke-test tag and release-history drift are already resolved.

## Current State

`docs/RELEASING.md` documents tag format, required files, validation commands, expected assets, and release boundaries.

`AGENTS.md`, `CONTRIBUTING.md`, `.github/PULL_REQUEST_TEMPLATE.md`, and `.github/copilot-instructions.md` repeat pieces of the release process.

The release document does not explain the pull-request landing flow, branch protection expectations, CI status check name, or draft-release workflow behavior.

## Target State

`docs/RELEASING.md` becomes the authoritative release and change-landing process.

Other maintenance files point to `docs/RELEASING.md` instead of duplicating detailed release steps.

The release document names the required CI check as `Validate skill package`.

The release document explains that tags use `vX.Y.Z`, release notes live at `docs/releases/vX.Y.Z.md`, and `CHANGELOG.md` must contain `## [vX.Y.Z]`.

The release document describes the workflow state after workflow drift has been corrected: CI uses `npm run package -- v0.0.0` as the packaging smoke test.

## Files

- Modify `docs/RELEASING.md`.
- Modify `AGENTS.md`.
- Modify `CONTRIBUTING.md`.
- Modify `.github/PULL_REQUEST_TEMPLATE.md`.
- Modify `.github/copilot-instructions.md`.
- Modify `CHANGELOG.md` only when this phase is prepared for release.
- Add `docs/releases/vX.Y.Z.md` only when this phase is included in a release.

## Task 1: Expand The Release Document

### Step 1: Replace The Opening

- [ ] Replace the current `Release Source` opening with a broader introduction.

Expected text:

```markdown
## Purpose

This document is the single source for how changes land in this repository and how releases are cut. Keep detailed release workflow instructions here so agent instructions, contribution docs, and pull request templates can link to one maintained process.
```

### Step 2: Add How Changes Land

- [ ] Add a `How Changes Land` section.

Expected text:

```markdown
## How Changes Land

Every change should land through a pull request into `main`.

The normal flow is:

1. Create a branch from `main`.
2. Make the change and run `npm run validate`.
3. Run `npm run package -- v0.0.0` when packaging or release behavior changed.
4. Push the branch and open a pull request into `main`.
5. Wait for the `Validate skill package` check to pass.
6. Resolve review conversations.
7. Squash-merge the pull request.
```

### Step 3: Add Main Protection Expectations

- [ ] Add a `Main Protection` section.

Expected text:

```markdown
## Main Protection

The default branch should be protected by repository rules or branch protection. Direct pushes to `main`, force pushes, branch deletion, and non-linear history should be blocked when the repository host supports those controls.

The required status check should be named `Validate skill package`, which is the CI job in `.github/workflows/ci.yml`.
```

### Step 4: Add Continuous Integration

- [ ] Add a `Continuous Integration` section.

Expected text:

```markdown
## Continuous Integration

`.github/workflows/ci.yml` runs on pull requests, pushes to `main`, and manual dispatch. It runs `npm run validate` and a packaging smoke test.

Use `v0.0.0` as the CI smoke-test tag. It is a placeholder and not a release version.
```

### Step 5: Keep Release Boundaries

- [ ] Preserve the existing release boundary rule that release assets must not include `.intake`, private research folders, `.template`, `.git`, `.idea`, `.github`, `docs`, `tmp`, `dist`, `node_modules`, or local environment files.

## Task 2: Update Referencing Files

### Step 1: Update Agent Instructions

- [ ] In `AGENTS.md`, replace detailed release checklist repetition with a short pointer to `docs/RELEASING.md`.

Expected text:

```markdown
## Release Rules

Use `docs/RELEASING.md` as the single source for how changes land and how releases are cut.
```

Keep `npm run validate` in `AGENTS.md` because agents need the default validation command.

### Step 2: Update Contributing Guidance

- [ ] In `CONTRIBUTING.md`, add or update a `How Changes Land` section that points to `docs/RELEASING.md`.

Expected text:

```markdown
## How Changes Land

Changes should land through a pull request that passes the `Validate skill package` check. The full workflow is documented in `docs/RELEASING.md`.
```

### Step 3: Update Pull Request Template

- [ ] In `.github/PULL_REQUEST_TEMPLATE.md`, change the packaging validation checkbox from the old release-tag smoke test to `npm run package -- v0.0.0`.
- [ ] Add a checkbox for checking `docs/RELEASING.md` when release behavior changes.

Expected checkbox text:

```markdown
- [ ] Ran `npm run package -- v0.0.0` if packaging or release behavior changed
- [ ] Updated or checked `docs/RELEASING.md` if release behavior changed
```

### Step 4: Update Copilot Instructions

- [ ] In `.github/copilot-instructions.md`, replace the old release-tag smoke test with `npm run package -- v0.0.0`.
- [ ] Add a sentence pointing release workflow questions to `docs/RELEASING.md`.

## Task 3: Validate Documentation

### Step 1: Search For Old Smoke Tag Guidance

- [ ] Run `rg -n "npm run package -- v1\.0\.0" AGENTS.md CONTRIBUTING.md .github docs README.md`.

Expected output:

```text
```

Historical release notes may mention `v1.0.0` as a real release; those references do not need removal. If this command reports `.github/workflows/ci.yml`, apply the workflow-release-drift plan before finishing this phase.

### Step 2: Run Repository Validation

- [ ] Run `npm run validate`.

Expected output:

```text
Validation passed.
```

## Acceptance Criteria

- `docs/RELEASING.md` explains change landing, main protection, CI, tagging, draft releases, validation, assets, and release boundaries.
- `AGENTS.md`, `CONTRIBUTING.md`, `.github/PULL_REQUEST_TEMPLATE.md`, and `.github/copilot-instructions.md` point to `docs/RELEASING.md` for release workflow details.
- Active maintenance docs no longer recommend the old release-tag smoke-test command.
- `npm run validate` passes.

## Release Notes

When this phase ships, add a changelog entry that says release documentation is now the single source for branch, CI, packaging, tagging, and draft-release workflow guidance.
