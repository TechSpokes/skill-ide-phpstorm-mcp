# Releasing

## Release Source

Use Git tags in `vX.Y.Z` format as the release source of truth.

## Required Files

Before tagging `vX.Y.Z`, ensure:

- `CHANGELOG.md` contains `## [vX.Y.Z]`.
- `docs/releases/vX.Y.Z.md` exists.
- `packaging/codex-plugin/.codex-plugin/plugin.json` uses version `X.Y.Z`.
- `packaging/claude-plugin/.claude-plugin/plugin.json` uses version `X.Y.Z`.

## Validation

Run:

```bash
npm run validate
```

Run a packaging smoke test:

```bash
npm run package -- vX.Y.Z
```

Expected assets:

- `dist/assets/phpstorm-mcp-vX.Y.Z.zip`
- `dist/assets/phpstorm-mcp-codex-plugin-vX.Y.Z.zip`
- `dist/assets/phpstorm-mcp-claude-plugin-vX.Y.Z.zip`

## Release Boundaries

Release assets must not include `.intake`, private research folders, `.template`, `.git`, `.idea`, `.github`, `docs`, `tmp`, `dist`, `node_modules`, or local environment files.

The packaged skill may include only runtime skill files from `src/` and plugin manifests from `packaging/`.
