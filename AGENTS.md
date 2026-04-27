# Agent Instructions for phpstorm-mcp

## Summary

Maintain the TechSpokes `phpstorm-mcp` skill so future agents can use PhpStorm MCP tools effectively in PHP projects without depending on private bootstrap research.

The maintenance goal is to keep `src/SKILL.md`, focused references, packaging metadata, and documentation accurate as PhpStorm, PhpStorm MCP, Composer, PHP runtimes, and IDE integrations change.

## Canonical Skill Entry Point

`src/SKILL.md` is the runtime entry point. Keep it concise and action-oriented. Put detailed tool behavior, matrices, and maintenance procedures in `src/references/`.

## Definitions

`PhpStorm MCP` means the Model Context Protocol tools exposed by PhpStorm or its plugin for the current project.

`IDE-owned context` means information PhpStorm knows through project configuration, indexing, inspections, run configurations, interpreter settings, Composer integration, database tooling, or editor state.

`Terminal tools` means shell commands such as `rg`, `php`, `composer`, and project test commands.

`High-risk action` means an operation that can mutate broad file state, dependency state, database state, VCS state, Docker state, debug state, or IDE state.

`Release artifact` means a ZIP produced for installation. It must contain only runtime skill or plugin files.

`Intake` means human-provided maintenance material under `.intake/`. It is source evidence for maintainers, not runtime skill content.

## Must-Follow Rules

- Preserve `src/SKILL.md` as the canonical runtime skill entry point.
- Keep local paths, local database credentials, and raw research logs out of released skill content.
- Treat `.intake/` as maintainer source evidence, not as runtime skill guidance.
- Exclude `.intake`, private research folders, `.template`, `tmp`, `dist`, `.git`, `.idea`, `.github`, `docs`, and `node_modules` from release artifacts.
- Prefer focused reference files over expanding `src/SKILL.md` with long detail.
- Update packaging manifests when the skill name, version, description, or repository identity changes.
- Update `CHANGELOG.md` and `docs/releases/` for release-relevant changes.
- Validate after changes with `npm run validate`.

## Maintenance Guidelines

When adding guidance, preserve the core routing rule: use PhpStorm MCP for IDE-owned semantic context and terminal tools for exact output, shell control, and fallback verification.

When a new PhpStorm MCP tool appears, test it in a disposable fixture before recommending it. Classify it as recommended, fallback, discovery-only, unreliable, unavailable, or high-risk.

When changing safety guidance, update the relevant reference and `docs/MAINTENANCE-CAPABILITY-SWEEP.md`. High-risk guidance must include explicit scope, user approval, before and after evidence, and verification.

When updating references, keep each file focused on one decision area. Avoid duplicating full matrices across files.

When processing `.intake/`, transform durable findings into `src/` or `docs/`. Do not copy raw notes, credentials, proprietary examples, or local paths into the released skill.

## Validation Commands

Run the repository validation command:

```bash
npm run validate
```

Run a packaging smoke test before release:

```bash
npm run package -- v1.0.0
```

Use the intended release tag instead of `v1.0.0` for later releases.

## Release Rules

Use tags in `vX.Y.Z` format.

Before release, ensure:

- `CHANGELOG.md` contains `## [vX.Y.Z]`.
- `docs/releases/vX.Y.Z.md` exists.
- Plugin manifests use version `X.Y.Z`.
- `npm run validate` passes.
- `npm run package -- vX.Y.Z` creates the expected ZIP files.

## Rationale

The skill exists because PhpStorm has semantic project knowledge that terminal tools cannot reliably infer. The release boundary protects users from installing raw research, local credentials, bootstrap files, or disposable fixtures as runtime instructions.
