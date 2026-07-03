# Install

## Installation Goal

Install release ZIP contents, not clone-time repository scaffolding. Keep `SKILL.md` and its support folders together so relative links from the skill entry point keep working.

Release ZIPs contain the runtime skill package and plugin manifests. They do not include repository docs, workflows, raw intake, local fixtures, temporary output, or private research.

## Get The Latest Release

Open the [latest GitHub release](https://github.com/TechSpokes/skill-ide-phpstorm-mcp/releases/latest) and download one ZIP asset.

- Download `phpstorm-mcp-vX.Y.Z.zip` for a direct skill-folder install.
- Download `phpstorm-mcp-codex-plugin-vX.Y.Z.zip` for Codex plugin installation when your host supports plugin ZIPs.
- Download `phpstorm-mcp-claude-plugin-vX.Y.Z.zip` for Claude plugin installation when your host supports plugin ZIPs.

Do not install the source repository ZIP from GitHub. It contains maintenance files that are not part of the runtime skill package.

## Standalone Skill

Use the standalone release ZIP when the host accepts a skill folder directly.

The ZIP contains:

```text
phpstorm-mcp/
|-- SKILL.md
`-- references/
```

For repository-shared skills, prefer `.agents/skills/`. Extract the ZIP so the final path is `.agents/skills/phpstorm-mcp/SKILL.md`.

Codex scans `.agents/skills/` from the working directory up to the repository root. GitHub Copilot also reads `.agents/skills/`.

## Tool-Specific Locations

These locations also work when a project or user needs a host-specific installation.

- `.claude/skills/` for Claude Code project skills.
- `~/.claude/skills/` for personal Claude Code skills across projects.
- `.github/skills/` for GitHub Copilot.

Keep the top-level `phpstorm-mcp/` directory from the ZIP. Do not copy only `SKILL.md`; the files under `references/` are part of the installed skill.

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

Install the whole ZIP or extracted plugin directory according to your host's plugin instructions. The plugin manifest and `skills/` directory must stay together.

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

Install the whole ZIP or extracted plugin directory according to your host's plugin instructions. The plugin manifest and `skills/` directory must stay together.

## After Installation

Open the target project in PhpStorm, make sure PhpStorm MCP is available to the coding agent, and ask the agent to use `phpstorm-mcp`.

Example request:

```text
Use the PhpStorm MCP skill to inspect this project, route IDE-owned context through PhpStorm MCP, and verify changes with terminal commands where needed.
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
