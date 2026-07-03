# Install

## Installation Goal

Install release ZIP contents, not clone-time repository scaffolding. Keep `SKILL.md` and its support folders together so relative links from the skill entry point keep working.

Release ZIPs contain the runtime skill package and plugin manifests. They do not include repository docs, workflows, raw intake, local fixtures, temporary output, or private research.

## Standalone Skill

Use the standalone release ZIP when the host accepts a skill folder directly.

The ZIP contains:

```text
phpstorm-mcp/
|-- SKILL.md
`-- references/
```

For repository-shared skills, prefer `.agents/skills/`. Codex scans this location from the working directory up to the repository root, and GitHub Copilot also reads it.

## Tool-Specific Locations

These locations also work when a project or user needs a host-specific install.

- `.claude/skills/` for Claude Code project skills.
- `~/.claude/skills/` for personal Claude Code skills across projects.
- `.github/skills/` for GitHub Copilot.

## Codex Plugin

Use `phpstorm-mcp-codex-plugin-vX.Y.Z.zip` when installing through a Codex plugin-compatible host.

The ZIP contains:

```text
phpstorm-mcp-codex-plugin/
|-- .codex-plugin/
|   +-- plugin.json
+-- skills/
    +-- phpstorm-mcp/
```

## Claude Plugin

Use `phpstorm-mcp-claude-plugin-vX.Y.Z.zip` when installing through a Claude plugin-compatible host.

The ZIP contains:

```text
phpstorm-mcp-claude-plugin/
|-- .claude-plugin/
|   +-- plugin.json
+-- skills/
    +-- phpstorm-mcp/
```

## Local Validation

Run:

```bash
npm run validate
```

Package locally with:

```bash
npm run package -- vX.Y.Z
```
