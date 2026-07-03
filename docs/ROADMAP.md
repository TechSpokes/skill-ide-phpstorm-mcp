# Roadmap

## Purpose

This roadmap turns the template comparison findings into an ordered maintenance path for the `phpstorm-mcp` skill repository. The goal is to keep the runtime skill stable while updating packaging, release process, install guidance, and maintenance conventions to the current base-template baseline.

## Roadmap Principles

- Keep `src/SKILL.md` and `src/references/` stable unless a phase explicitly requires runtime guidance changes.
- Prefer small pull requests that can be validated with `npm run validate`.
- Use `npm run package -- v0.0.0` as the packaging smoke test for maintenance changes.
- Update `CHANGELOG.md` and `docs/releases/` only when a phase is being prepared for an actual release.
- Keep release packages limited to runtime skill files and plugin manifests.

## Repository Values

The repository exists to maintain and release one runtime skill, `phpstorm-mcp`, without leaking local construction material or private evidence into installed packages.

Preserve the runtime boundary. `src/SKILL.md` and `src/references/` are installed skill content. Repository docs, workflows, `.intake/`, local feedback notes, `dist/`, `tmp/`, and private research are maintenance material unless a plan explicitly says otherwise.

Prefer maintainer clarity over preserving old template wording. When a local decision is needed, choose the option that keeps release artifacts clean, makes validation deterministic, and helps a future agent maintain the skill without knowing the template history.

Do not broaden the runtime skill while executing these phases. These phases harden packaging, documentation, release process, and maintenance conventions.

## Execution Rules

Start every phase by reading `AGENTS.md`, `.github/instructions/markdown.instructions.md`, this roadmap, and the phase plan.

Run `git status --short` before editing. Preserve unrelated user changes and do not revert files outside the phase scope.

Use `apply_patch` for manual edits. Do not create or edit files with shell redirection.

Validate each phase with the commands named in its plan. Treat a missing or weaker validation signal as incomplete work.

## Phase Order

### Phase 1: Manifest Metadata

Plan: [manifest-metadata.plan.md](plans/manifest-metadata/manifest-metadata.plan.md)

Add required manifest metadata and strengthen validation so missing plugin `license` fields and missing Claude `displayName` are caught before release.

### Phase 2: Package Pruning

Plan: [package-pruning.plan.md](plans/package-pruning/package-pruning.plan.md)

Update release packaging to skip `.gitkeep` placeholders and prune empty staged directories while preserving all expected ZIP assets.

### Phase 3: Install Locations

Plan: [install-locations.plan.md](plans/install-locations/install-locations.plan.md)

Update install documentation to identify `.agents/skills/` as the preferred repository-shared standalone skill location and list supported host-specific skill locations.

### Phase 4: Workflow Release Drift

Plan: [workflow-release-drift.plan.md](plans/workflow-release-drift/workflow-release-drift.plan.md)

Correct CI smoke-test tag guidance, add an explicit changelog file guard to the draft-release workflow, and fix release-history wording that mentions an obsolete checkout action version.

### Phase 5: Release Process

Plan: [release-process.plan.md](plans/release-process/release-process.plan.md)

Make `docs/RELEASING.md` the single source for change landing, main protection, CI, packaging smoke tests, tagging, and draft-release behavior.

### Phase 6: Template Feedback

Plan: [template-feedback.plan.md](plans/template-feedback/template-feedback.plan.md)

Add a local `.skill-template-feedback/` convention so future maintainers can capture template defects and route durable improvements upstream without changing runtime skill packages.

## Suggested Release Grouping

The first release should include Phases 1, 2, 3, 4, and 5 because they are all repository-maintenance hardening changes discovered from the same template comparison. Phase 6 can ship in the same release if maintainers want the feedback convention immediately, or it can wait for a later maintenance release because it does not affect release correctness.

Phase 5 depends on Phase 4 because the release-process plan documents `v0.0.0` as the active packaging smoke-test tag. Apply Phase 4 first or adjust Phase 5 validation if the workflow drift has already been resolved by another change.

## Validation Gates

Each phase must pass `npm run validate`.

Phases that touch packaging, manifests, CI, release workflow, or release docs must also pass `npm run package -- v0.0.0`.

Before cutting a real release, run `npm run package -- vX.Y.Z` with the intended tag and verify the three expected ZIP files under `dist/assets/`.

## Implementation Status

All six phases have been implemented in the working tree. The GitHub repository settings described in `docs/RELEASING.md` were applied on 2026-07-03, including squash-only merging, disabled Projects and Wiki, enabled security checks, and the active `main protection` ruleset.

Keep the phase plans as maintenance records for future review, and use `CHANGELOG.md` for unreleased implementation notes until the next release version is chosen.
