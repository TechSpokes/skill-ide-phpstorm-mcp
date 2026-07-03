# Manifest Metadata Implementation Plan

> For agentic workers: REQUIRED SUB-SKILL: Use `superpowers:subagent-driven-development` or `superpowers:executing-plans` to implement this plan task by task. Steps use checkbox syntax for tracking.

## Goal

Align plugin manifest metadata and validation with the current repository baseline so released Codex and Claude plugin packages carry required identity fields.

## Architecture

This phase changes only packaging metadata and the validator that enforces it. The runtime skill under `src/` must not change.

## Repository Context

This repository packages one runtime skill, `phpstorm-mcp`. Preserve the release boundary: `src/SKILL.md` and `src/references/` are runtime skill content, while `docs/`, `.github/`, `.intake/`, `dist/`, `tmp/`, and local research are repository maintenance material.

When local judgment is needed, choose the option that keeps package identity explicit, release artifacts clean, validation deterministic, and runtime guidance unchanged.

## Tech Stack

- Node.js ES modules for `scripts/validate-skill.mjs`.
- JSON plugin manifests under `packaging/`.
- Repository validation through `npm run validate`.

## Preconditions

- Read `AGENTS.md`, `.github/instructions/markdown.instructions.md`, `docs/ROADMAP.md`, and this plan before editing.
- Run `git status --short` and preserve unrelated user changes.
- Apply this phase before cutting the next release that should enforce manifest metadata.

## Current State

The Codex manifest at `packaging/codex-plugin/.codex-plugin/plugin.json` does not contain a top-level `license` field.

The Claude manifest at `packaging/claude-plugin/.claude-plugin/plugin.json` does not contain a top-level `license` field or a top-level `displayName` field.

The validator at `scripts/validate-skill.mjs` currently checks plugin manifests for `name`, `version`, and `description` only.

## Target State

Both plugin manifests include top-level `license` with value `MIT`.

The Claude plugin manifest includes top-level `displayName` with value `PhpStorm MCP`.

The validator fails when either plugin manifest is missing `license`.

The validator fails when the Claude plugin manifest is missing top-level `displayName`.

## Files

- Modify `packaging/codex-plugin/.codex-plugin/plugin.json`.
- Modify `packaging/claude-plugin/.claude-plugin/plugin.json`.
- Modify `scripts/validate-skill.mjs`.
- Modify `CHANGELOG.md` only when this phase is prepared for release.
- Add `docs/releases/vX.Y.Z.md` only when this phase is included in a release.

## Task 1: Add Manifest Metadata

### Step 1: Edit The Codex Manifest

- [ ] Add `"license": "MIT"` after the `repository` field in `packaging/codex-plugin/.codex-plugin/plugin.json`.

Expected metadata excerpt:

```json
{
  "name": "phpstorm-mcp",
  "version": "1.1.0",
  "description": "Agent skill for using PhpStorm MCP tools in PhpStorm projects.",
  "author": {
    "name": "TechSpokes",
    "url": "https://www.techspokes.com"
  },
  "homepage": "https://github.com/TechSpokes/skill-ide-phpstorm-mcp",
  "repository": "https://github.com/TechSpokes/skill-ide-phpstorm-mcp",
  "license": "MIT",
  "keywords": [
    "agent-skill",
    "codex-plugin",
    "phpstorm",
    "mcp",
    "php",
    "jetbrains"
  ]
}
```

Do not replace the full manifest with this excerpt. Keep the existing `skills` and `interface` fields below `keywords`; the excerpt shows only the metadata area that must change.

### Step 2: Edit The Claude Manifest

- [ ] Add `"displayName": "PhpStorm MCP"` after the `name` field in `packaging/claude-plugin/.claude-plugin/plugin.json`.
- [ ] Add `"license": "MIT"` after the `repository` field in `packaging/claude-plugin/.claude-plugin/plugin.json`.

Expected metadata excerpt:

```json
{
  "name": "phpstorm-mcp",
  "displayName": "PhpStorm MCP",
  "version": "1.1.0",
  "description": "Agent skill for using PhpStorm MCP tools in PhpStorm projects.",
  "author": {
    "name": "TechSpokes",
    "url": "https://www.techspokes.com"
  },
  "homepage": "https://github.com/TechSpokes/skill-ide-phpstorm-mcp",
  "repository": "https://github.com/TechSpokes/skill-ide-phpstorm-mcp",
  "license": "MIT",
  "keywords": [
    "agent-skill",
    "claude-plugin",
    "phpstorm",
    "mcp",
    "php",
    "jetbrains"
  ]
}
```

## Task 2: Strengthen Manifest Validation

### Step 1: Expand Required Manifest Keys

- [ ] In `scripts/validate-skill.mjs`, find the manifest key loop inside `validateManifests()`.
- [ ] Change the key list from `["name", "version", "description"]` to `["name", "version", "description", "license"]`.

Expected code:

```javascript
for (const key of ["name", "version", "description", "license"]) {
  if (!manifest[key]) {
    fail(`${manifestPath} is missing ${key}.`);
  }
}
```

### Step 2: Require Claude Display Name

- [ ] Add a check after the required key loop in `validateManifests()`.

Expected code:

```javascript
if (manifestPath.includes(".claude-plugin") && !manifest.displayName) {
  fail(`${manifestPath} is missing top-level displayName.`);
}
```

## Task 3: Validate The Phase

### Step 1: Run Repository Validation

- [ ] Run `npm run validate`.

Expected output:

```text
Validation passed.
```

### Step 2: Smoke Test Packaging

- [ ] Run `npm run package -- v0.0.0`.

Expected output:

```text
Packaged release assets for phpstorm-mcp v0.0.0.
```

### Step 3: Inspect Packaged Manifests

- [ ] Confirm `dist/stage/phpstorm-mcp-codex-plugin/.codex-plugin/plugin.json` includes `"license": "MIT"`.
- [ ] Confirm `dist/stage/phpstorm-mcp-claude-plugin/.claude-plugin/plugin.json` includes `"displayName": "PhpStorm MCP"`.
- [ ] Confirm `dist/stage/phpstorm-mcp-claude-plugin/.claude-plugin/plugin.json` includes `"license": "MIT"`.

## Acceptance Criteria

- `npm run validate` fails if either plugin manifest lacks `license`.
- `npm run validate` fails if the Claude plugin manifest lacks top-level `displayName`.
- Both plugin manifests contain the new metadata fields.
- Packaging still creates the standalone skill ZIP and both plugin ZIPs.
- No runtime files under `src/` are changed by this phase.

## Release Notes

When this phase ships, add a changelog entry that says plugin manifests now include required license metadata and Claude display name metadata, and validation enforces those fields.
