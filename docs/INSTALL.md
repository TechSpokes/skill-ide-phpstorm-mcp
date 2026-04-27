# Install

## Standalone Skill

Use the standalone release ZIP when the host accepts a skill folder directly.

The ZIP contains:

```text
phpstorm-mcp/
|-- SKILL.md
+-- references/
```

Place the extracted `phpstorm-mcp` folder in the host's skill directory.

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
