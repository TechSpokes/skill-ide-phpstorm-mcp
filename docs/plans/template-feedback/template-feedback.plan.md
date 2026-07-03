# Template Feedback Implementation Plan

> For agentic workers: REQUIRED SUB-SKILL: Use `superpowers:subagent-driven-development` or `superpowers:executing-plans` to implement this plan task by task. Steps use checkbox syntax for tracking.

## Goal

Add a local feedback channel for template-origin improvements discovered while maintaining this generated skill repository.

## Architecture

This phase adds a root `.skill-template-feedback/` convention and updates maintenance guidance so future agents can record template gaps without mixing local notes into runtime skill content.

## Repository Context

This repository was generated from a reusable skill template, but it now stands alone as the `phpstorm-mcp` skill repository. Preserve that identity: do not restore `.template/`, do not make runtime skill behavior depend on template files, and do not package local feedback notes.

When local judgment is needed, choose the option that lets maintainers capture upstream template improvements while keeping release artifacts and runtime skill guidance clean.

## Tech Stack

- Markdown convention file under `.skill-template-feedback/`.
- `.gitignore` rules for local note isolation.
- Maintenance guidance in `AGENTS.md`.
- Repository validation through `npm run validate`.

## Preconditions

- Read `AGENTS.md`, `.github/instructions/markdown.instructions.md`, `docs/ROADMAP.md`, and this plan before editing.
- Run `git status --short` and preserve unrelated user changes.
- Do not add `.template/`, `.plans/`, or template bootstrap documents to this repository.

## Current State

The repository was built from a base skill template but does not have a dedicated folder for routing template gaps upstream.

The current `.gitignore` ignores `node_modules/`, `dist/`, `tmp/`, `.template/state/`, `.idea/`, and `*.log`.

`AGENTS.md` does not tell maintainers where to capture template defects or upgrade notes.

## Target State

The repository contains `.skill-template-feedback/README.md`.

The repository contains `.skill-template-feedback/.gitkeep`.

`.gitignore` ignores all local files under `.skill-template-feedback/` except `README.md` and `.gitkeep`.

`AGENTS.md` tells maintainers to record template gaps in `.skill-template-feedback/` and route durable fixes upstream to `TechSpokes/skill-base-template`.

Release packaging continues to exclude `.skill-template-feedback/` because packages copy only `src/` and plugin manifests.

## Files

- Create `.skill-template-feedback/README.md`.
- Create `.skill-template-feedback/.gitkeep`.
- Modify `.gitignore`.
- Modify `AGENTS.md`.
- Modify `CHANGELOG.md` only when this phase is prepared for release.
- Add `docs/releases/vX.Y.Z.md` only when this phase is included in a release.

## Task 1: Add The Feedback Folder

### Step 1: Create The Directory Files

- [ ] Create `.skill-template-feedback/README.md`.
- [ ] Create `.skill-template-feedback/.gitkeep`.

Expected `README.md` content:

```markdown
# Skill Template Feedback

This folder is a local staging area for notes and artifacts about the template this skill was generated from, `TechSpokes/skill-base-template`.

When maintaining this skill reveals a gap in the template, capture it here, then surface it upstream as an issue or pull request so future generated skills inherit the fix.

The contents of this folder are git-ignored on purpose. Only this `README.md` and `.gitkeep` are tracked, so the convention travels with the repository while working notes stay local.

Nothing in this folder ships in the skill package.
```

### Step 2: Keep The Placeholder Empty

- [ ] Leave `.skill-template-feedback/.gitkeep` empty.

## Task 2: Add Ignore Rules

### Step 1: Edit `.gitignore`

- [ ] Append the ignore rules below to `.gitignore`.

Expected rules:

```gitignore
.skill-template-feedback/*
!.skill-template-feedback/.gitkeep
!.skill-template-feedback/README.md
```

### Step 2: Preserve Existing Ignores

- [ ] Keep the existing `node_modules/`, `dist/`, `tmp/`, `.template/state/`, `.idea/`, and `*.log` rules.

## Task 3: Update Agent Instructions

### Step 1: Add A Maintenance Guidance Paragraph

- [ ] In `AGENTS.md`, add guidance under `Maintenance Guidelines`.

Expected text:

```markdown
When maintenance reveals a defect or missing safeguard in the base template, capture the local note under `.skill-template-feedback/`. Do not copy local feedback notes into release packages. Route durable fixes upstream to `TechSpokes/skill-base-template` when they should benefit future generated skill repositories.
```

### Step 2: Preserve Release Boundary Rules

- [ ] Keep the existing release artifact exclusion rule in `AGENTS.md`.
- [ ] Do not add `.skill-template-feedback/` to packaged content.

## Task 4: Validate The Phase

### Step 1: Verify Tracked Convention Files

- [ ] Run `git status --short .skill-template-feedback .gitignore AGENTS.md`.

Expected output includes:

```text
?? .skill-template-feedback/
 M .gitignore
 M AGENTS.md
```

Output may differ after files are staged, but the README and `.gitkeep` must be visible to Git.

### Step 2: Verify Local Feedback Notes Are Ignored

- [ ] Create a temporary local file named `.skill-template-feedback/local-test-note.md`.
- [ ] Run `git status --short .skill-template-feedback/local-test-note.md`.

Expected output:

```text
```

- [ ] Delete `.skill-template-feedback/local-test-note.md`.

Use PowerShell `Remove-Item -LiteralPath '.skill-template-feedback\local-test-note.md'` for this single temporary file.

### Step 3: Run Repository Validation

- [ ] Run `npm run validate`.

Expected output:

```text
Validation passed.
```

## Acceptance Criteria

- `.skill-template-feedback/README.md` and `.skill-template-feedback/.gitkeep` exist.
- Local feedback notes under `.skill-template-feedback/` are ignored by Git.
- `AGENTS.md` explains when and how to use the feedback folder.
- Release packages remain limited to runtime skill files and plugin manifests.
- `npm run validate` passes.

## Release Notes

When this phase ships, add a changelog entry that says the repository now has a local template-feedback channel for upstream template improvement notes.
