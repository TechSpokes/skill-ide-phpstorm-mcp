# Adoption Research

This document is maintainer guidance for improving the public copy and runtime guidance of `phpstorm-mcp`. It is not packaged with release artifacts.

## Research Goal

Improve skill adoption by explaining the real PHP developer problem: agents need PhpStorm's project context, but developers still need deterministic terminal verification and approval boundaries.

## Current Evidence

JetBrains documents PhpStorm 2025.2 and later as including an integrated MCP server for clients such as Claude Desktop, Cursor, Codex, VS Code, and others. The public tool list includes run configurations, inspections, project modules, dependencies, file operations, search, symbol info, rename refactoring, terminal execution, VCS roots, and database tools.

JetBrains AI Assistant documentation positions MCP as a way for AI Assistant to connect to external tools and data sources. PhpStorm's AI page also positions agents as selectable inside the IDE, including Junie, Claude Agent, and Codex.

JetBrains' State of PHP 2025 reports strong PhpStorm usage among PHP developers, increased AI adoption, high interest in AI coding agents, and continuing use of PHPUnit, Pest, PHPStan, PHP CS Fixer, PHP_CodeSniffer, and Rector. It also notes that a meaningful share of PHP developers still do not write tests or use code quality tools regularly.

JetBrains' 2025 AI report highlights developer concerns that map directly to this skill: generated code quality, limited understanding of complex code, privacy and security, lack of context awareness, and poor integration with existing workflows.

Community discussion from PHP developers describes a common failure mode for agents in large proprietary PHP codebases: agents can handle small visible snippets, but struggle with custom frameworks, routing, ORM layers, controllers, caching, forms, multi-repository structure, and architecture that is absent from public training data.

## Adoption Hypotheses

The README should lead with trust and workflow fit, not skill-maintenance mechanics.

PHP developers are more likely to try the skill when copy names problems they already experience.

- The shell and PhpStorm can disagree about PHP, Composer, Docker, WSL, or SSH.
- Text replacement is unsafe for PHP symbols in framework-heavy projects.
- Agents need project indexing to avoid wrong files and abstractions.
- Inspections, code quality tools, and tests need scoped verification.
- Database, dependency, cleanup, and IDE actions need explicit approval boundaries.

The runtime skill should keep its concise decision workflow, but it must avoid implying every PhpStorm MCP installation exposes the same schema. Public docs show built-in MCP tools that overlap with, but do not exactly match, the local capability set used to create this skill.

## Research Plan

Repeat this research before major README or runtime guidance changes.

1. Read the current JetBrains PhpStorm MCP documentation.
2. Note supported clients, setup, tool names, and safety settings.
3. Read the JetBrains AI Assistant MCP documentation and PhpStorm AI page.
4. Review the latest JetBrains State of PHP and Developer Ecosystem AI reports.
5. Sample current PHP community discussions.
6. Group pain points by agent failure mode.
7. Compare public tool names against `src/SKILL.md` and `src/references/`.
8. Test new or changed tool behavior in a disposable fixture.
9. Update README copy and tested runtime guidance, then run validation.

## Sources Checked

- JetBrains PhpStorm MCP Server documentation, last checked 2026-04-27.
- JetBrains AI Assistant MCP documentation, last checked 2026-04-27.
- JetBrains PhpStorm AI feature page, last checked 2026-04-27.
- JetBrains State of PHP 2025, last checked 2026-04-27.
- JetBrains State of Developer Ecosystem 2025 AI report, last checked 2026-04-27.
- JetBrains PHP tests with AI Assistant post, last checked 2026-04-27.
- Reddit `r/PHP` AI agents discussion, last checked 2026-04-27.
- Reddit `r/laravel` PhpStorm AI discussion, last checked 2026-04-27.
- Laracasts discussion on AI-powered IDEs for Laravel development, last checked 2026-04-27.
