# Workflow Release Drift Implementation Plan

> For agentic workers: REQUIRED SUB-SKILL: Use `superpowers:subagent-driven-development` or `superpowers:executing-plans` to implement this plan task by task. Steps use checkbox syntax for tracking.

## Goal

Correct small drift between CI, release workflow checks, and release-history documentation so the repository accurately describes its current automation.

## Architecture

This phase changes workflow text and release-history documentation. It does not change the runtime skill and should not change release asset layout.

## Repository Context

This repository packages one runtime skill, `phpstorm-mcp`. Preserve the release automation contract: CI verifies the package, the tag workflow drafts a release, and packaging writes the standalone skill ZIP plus Codex and Claude plugin ZIPs.

When local judgment is needed, choose the option that makes automation behavior match the documentation and makes failure messages clearer without changing release asset names or runtime skill guidance.

## Tech Stack

- GitHub Actions YAML under `.github/workflows/`.
- Markdown release history under `CHANGELOG.md` and `docs/releases/`.
- Repository validation through `npm run validate`.

## Preconditions

- Read `AGENTS.md`, `.github/instructions/markdown.instructions.md`, `docs/ROADMAP.md`, and this plan before editing.
- Run `git status --short` and preserve unrelated user changes.
- Apply this phase before `docs/plans/release-process/release-process.plan.md` so release-process documentation can describe current workflow behavior.

## Current State

Before this phase was implemented, `.github/workflows/ci.yml` used the first public release tag as its package smoke-test tag.

The current generated-template baseline uses `v0.0.0` for CI smoke tests so maintainers do not mistake the smoke tag for a real release.

`.github/workflows/release-draft.yml` checks for the changelog heading but does not first check that `CHANGELOG.md` exists.

Before this phase was implemented, `CHANGELOG.md` named an obsolete checkout action version for the `v1.1.0` release while the workflow used the current version.

Before this phase was implemented, `docs/releases/v1.1.0.md` also named the obsolete checkout action version.

## Target State

CI uses `npm run package -- v0.0.0` as a placeholder smoke-test tag.

The draft release workflow reports a clear missing-file error when `CHANGELOG.md` is absent.

Release-history wording no longer contradicts the current workflow state.

## Files

- Modify `.github/workflows/ci.yml`.
- Modify `.github/workflows/release-draft.yml`.
- Modify `CHANGELOG.md`.
- Modify `docs/releases/v1.1.0.md`.
- Modify `CHANGELOG.md` again only if this phase is prepared for a future release.
- Add `docs/releases/vX.Y.Z.md` only when this phase is included in a future release.

## Task 1: Update CI Smoke Tag

### Step 1: Change The Package Smoke Test

- [ ] In `.github/workflows/ci.yml`, replace the old release-tag smoke test with `npm run package -- v0.0.0`.

Expected YAML:

```yaml
      - name: Package smoke test
        run: npm run package -- v0.0.0
```

### Step 2: Keep The Job Name

- [ ] Preserve the job name `Validate skill package`.

This name is used by release-process documentation and branch protection expectations.

## Task 2: Add Changelog File Guard

### Step 1: Edit The Release Metadata Script

- [ ] In `.github/workflows/release-draft.yml`, locate the `Resolve release metadata` step.
- [ ] Add a file existence check for `CHANGELOG.md` before the `grep` command.

Expected Bash block:

```bash
          if [[ ! -f CHANGELOG.md ]]; then
            echo "Missing CHANGELOG.md." >&2
            exit 1
          fi

          if ! grep -Fq "## [${tag}]" CHANGELOG.md; then
            echo "CHANGELOG.md is missing required section: ## [${tag}]" >&2
            exit 1
          fi
```

### Step 2: Preserve Tag And Notes Checks

- [ ] Do not change the existing tag regex.
- [ ] Do not change the existing release notes file check.
- [ ] Do not change release asset upload behavior.

## Task 3: Correct Release History Drift

### Step 1: Update The Changelog Historical Entry

- [ ] In `CHANGELOG.md`, change the `v1.1.0` bullet from the obsolete checkout action version to `actions/checkout@v7`.

Expected bullet:

```markdown
- Update CI and release workflows to use `actions/checkout@v7`.
```

### Step 2: Update The Release Notes Historical Entry

- [ ] In `docs/releases/v1.1.0.md`, change the included item from the obsolete checkout action version to `actions/checkout@v7`.

Expected bullet:

```markdown
- Updated CI and release workflows to use `actions/checkout@v7`.
```

### Step 3: Record The Correction In Unreleased Notes

- [ ] Add a current `Unreleased` entry in `CHANGELOG.md` only if this phase is being prepared as a normal change.

Expected `Unreleased` section:

```markdown
## [Unreleased]

- Correct release-history wording and CI smoke-test tag guidance.
```

Replace `No unreleased changes.` with the bullet when this phase is implemented. Do not create a new version section until the release version is chosen.

## Task 4: Validate The Phase

### Step 1: Search For Old Smoke Tag Guidance

- [ ] Run `rg -n "npm run package -- v1\.0\.0" .github docs AGENTS.md CONTRIBUTING.md README.md`.

Expected output:

```text
```

Historical file names and real release references may still contain `v1.0.0`; the search is for the smoke-test command only.

### Step 2: Search For Checkout Drift

- [ ] Search `.github`, `CHANGELOG.md`, and `docs` for the obsolete checkout action version.

Expected output:

```text
```

### Step 3: Run Repository Validation

- [ ] Run `npm run validate`.

Expected output:

```text
Validation passed.
```

## Acceptance Criteria

- CI uses `v0.0.0` as the packaging smoke-test tag.
- The draft release workflow has a dedicated `CHANGELOG.md` existence check.
- Active and historical release docs no longer name the obsolete checkout action version.
- `npm run validate` passes.

## Release Notes

When this phase ships, add a changelog entry that says workflow smoke-test and release-history drift were corrected.
