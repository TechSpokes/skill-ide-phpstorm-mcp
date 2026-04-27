# Intake

Use this folder for human-provided material that maintainers should review when updating the `phpstorm-mcp` skill.

Examples include:

- Notes about new PhpStorm MCP behavior.
- Sanitized test reports from real PHP projects.
- Public examples of Composer, interpreter, run configuration, or database workflows.
- Proposed documentation changes.
- Screenshots or transcripts with private data removed.

## Rules

- Do not add secrets, credentials, proprietary code, or private customer material.
- Do not treat files in this folder as runtime skill content.
- Do not package this folder in release artifacts.
- Transform durable findings into `src/SKILL.md`, `src/references/`, or `docs/`.
- Delete temporary or sensitive material after the maintenance update is complete.

## Maintainer Workflow

1. Read new files in this folder as source evidence.
2. Identify which findings are tested, inferred, outdated, or unsafe to publish.
3. Move reusable runtime guidance into `src/`.
4. Move repository maintenance guidance into `docs/`.
5. Run validation before release.
