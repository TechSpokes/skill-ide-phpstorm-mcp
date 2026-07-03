# Package Pruning Implementation Plan

> For agentic workers: REQUIRED SUB-SKILL: Use `superpowers:subagent-driven-development` or `superpowers:executing-plans` to implement this plan task by task. Steps use checkbox syntax for tracking.

## Goal

Ensure release ZIPs contain only real runtime skill content and plugin manifests by skipping `.gitkeep` placeholders and pruning empty staged directories.

## Architecture

This phase changes the release staging copy routine only. It does not change the public package names, release asset paths, runtime skill files, or plugin manifest format.

## Repository Context

This repository packages one runtime skill, `phpstorm-mcp`. Preserve the release boundary: release ZIPs may contain runtime skill files from `src/` and plugin manifests from `packaging/`, but must not contain repository docs, `.github/`, `.intake/`, local feedback notes, temporary files, or private research.

When local judgment is needed, choose the option that removes placeholder or empty packaging artifacts without changing package names, installed paths, or runtime skill guidance.

## Tech Stack

- Node.js ES modules for `scripts/package-release.mjs`.
- Local packaging through `npm run package -- v0.0.0`.
- File inspection through PowerShell or Git Bash.

## Preconditions

- Read `AGENTS.md`, `.github/instructions/markdown.instructions.md`, `docs/ROADMAP.md`, and this plan before editing.
- Run `git status --short` and preserve unrelated user changes.
- Prefer running this phase before release-process documentation updates so docs can describe the current packaging behavior.

## Current State

The `copyDir()` function in `scripts/package-release.mjs` recursively copies every source file into `dist/stage`.

If future source folders include only `.gitkeep`, packaging can ship empty directories or placeholder files.

The current `src/` tree does not require empty `assets/`, `scripts/`, or `test-fixtures/` directories to be present in release ZIPs.

## Target State

The packager skips files named `.gitkeep`.

The packager removes staged directories that become empty after recursive copying.

The generated ZIPs keep the same names and top-level folder structure.

## Files

- Modify `scripts/package-release.mjs`.
- Modify `CHANGELOG.md` only when this phase is prepared for release.
- Add `docs/releases/vX.Y.Z.md` only when this phase is included in a release.

## Task 1: Update The Copy Routine

### Step 1: Locate The Existing Function

- [ ] Open `scripts/package-release.mjs`.
- [ ] Find `function copyDir(source, destination)`.

Current function shape:

```javascript
function copyDir(source, destination) {
  fs.mkdirSync(destination, { recursive: true });
  for (const entry of fs.readdirSync(source, { withFileTypes: true })) {
    const sourcePath = path.join(source, entry.name);
    const destinationPath = path.join(destination, entry.name);
    if (entry.isDirectory()) {
      copyDir(sourcePath, destinationPath);
    } else {
      fs.copyFileSync(sourcePath, destinationPath);
    }
  }
}
```

### Step 2: Replace The Function

- [ ] Replace the body of `copyDir()` with the implementation below.

Expected code:

```javascript
function copyDir(source, destination) {
  fs.mkdirSync(destination, { recursive: true });
  for (const entry of fs.readdirSync(source, { withFileTypes: true })) {
    if (entry.name === ".gitkeep") {
      continue;
    }
    const sourcePath = path.join(source, entry.name);
    const destinationPath = path.join(destination, entry.name);
    if (entry.isDirectory()) {
      copyDir(sourcePath, destinationPath);
    } else {
      fs.copyFileSync(sourcePath, destinationPath);
    }
  }
  if (fs.readdirSync(destination).length === 0) {
    fs.rmdirSync(destination);
  }
}
```

### Step 3: Preserve Existing Behavior

- [ ] Do not change `stageStandalone()`.
- [ ] Do not change `stagePlugin()`.
- [ ] Do not change the ZIP file names.
- [ ] Do not change `resetDir()`.

## Task 2: Validate Packaging Output

### Step 1: Run Repository Validation

- [ ] Run `npm run validate`.

Expected output:

```text
Validation passed.
```

### Step 2: Run The Packaging Smoke Test

- [ ] Run `npm run package -- v0.0.0`.

Expected output:

```text
Packaged release assets for phpstorm-mcp v0.0.0.
```

### Step 3: Confirm Asset Paths

- [ ] Confirm `dist/assets/phpstorm-mcp-v0.0.0.zip` exists.
- [ ] Confirm `dist/assets/phpstorm-mcp-codex-plugin-v0.0.0.zip` exists.
- [ ] Confirm `dist/assets/phpstorm-mcp-claude-plugin-v0.0.0.zip` exists.

### Step 4: Confirm Placeholder Exclusion

- [ ] Search staged output for `.gitkeep`.

Run:

```powershell
Get-ChildItem -Path dist\stage -Recurse -Force -Filter .gitkeep
```

Expected output:

```text
```

### Step 5: Confirm Runtime Files Still Ship

- [ ] Confirm `dist/stage/phpstorm-mcp/SKILL.md` exists.
- [ ] Confirm `dist/stage/phpstorm-mcp/references/tool-selection.md` exists.
- [ ] Confirm `dist/stage/phpstorm-mcp-codex-plugin/skills/phpstorm-mcp/SKILL.md` exists.
- [ ] Confirm `dist/stage/phpstorm-mcp-claude-plugin/skills/phpstorm-mcp/SKILL.md` exists.

## Acceptance Criteria

- Packaging skips `.gitkeep` files.
- Packaging prunes empty staged directories.
- Packaging still creates all three expected release ZIPs.
- Runtime skill files and references still appear in the staged standalone and plugin packages.
- No documentation or manifest behavior changes are included unless required by release notes.

## Release Notes

When this phase ships, add a changelog entry that says release packaging now skips placeholder files and prunes empty staged directories.
