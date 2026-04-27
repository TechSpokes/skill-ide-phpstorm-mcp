# Contributing

## Purpose

This repository is maintained by TechSpokes for the `phpstorm-mcp` skill. Contributions should improve how agents use PhpStorm MCP safely in PhpStorm projects, including PHP and non-PHP repositories.

## Good Contributions

- Clarify PhpStorm MCP tool routing.
- Add evidence-backed capability classifications.
- Improve safety guidance for IDE actions, Composer, databases, and execution.
- Update references after a documented capability sweep.
- Improve validation or release packaging without changing runtime behavior.

## Before Opening A Pull Request

- Read `AGENTS.md`.
- Read `src/SKILL.md`.
- Run `npm run validate`.
- Run `npm run package -- vX.Y.Z` when changing packaging or release behavior.

## Evidence Standard

Do not promote a new MCP tool or IDE action based only on discovery. Test it in a disposable fixture or approved real project scope, then document the observed behavior.

## Sensitive Material

Do not commit secrets, private code, local database credentials, proprietary research, or machine-specific paths as skill guidance.

Use `.intake/` only for sanitized material that maintainers should review before turning it into skill guidance.
