# PhpStorm MCP Skill

`phpstorm-mcp` is a TechSpokes agent skill for PHP developers who want coding agents to use the same PhpStorm project intelligence they rely on every day.

It gives agents a practical operating model for PhpStorm MCP: use the IDE for semantic PHP work, project configuration, inspections, quick fixes, refactors, and interpreter-aware execution; use terminal tools when exact shell behavior and raw output matter more.

## Why PHP Developers Want This

Modern PHP projects hide critical truth in the IDE.

PhpStorm knows the active PHP language level, configured interpreter, Xdebug state, formatter rules, inspections, run configurations, Composer integration, indexed symbols, database tools, and framework-aware project context. A terminal-only agent can miss that context, especially when `php`, Composer, Docker, WSL, SSH, or a remote interpreter disagree.

This skill teaches the agent to ask PhpStorm first when the IDE has the project truth, then verify with terminal tools when deterministic output matters.

## What It Helps Agents Do

- Refresh live PHP project configuration before runtime-sensitive decisions.
- Detect PHP and Composer runtime mismatch.
- Search with IDE project awareness and fall back to `rg` when indexing may lag.
- Use PhpStorm inspections and quick fixes without broad cleanup surprises.
- Rename PHP symbols semantically instead of using text replacement.
- Run PHP scripts through the PhpStorm project interpreter.
- Treat database writes, Composer updates, delete actions, and broad IDE actions as high-risk.
- Validate edits with searches, inspections, tests, and `git status`.

## What It Does Not Do

This skill does not tell agents to abandon the terminal. Shell commands are still better for exact stdout, stderr, arguments, environment variables, working directories, pipes, process control, and fast raw file scans.

The skill also does not make broad IDE actions safe by default. It teaches agents to prefer direct MCP tools and scoped quick fixes, then require explicit approval for risky operations.

## How To Use It

Install the skill, then ask the agent to use PhpStorm MCP while working in a PHP project opened in PhpStorm.

Use prompts like these:

```text
Use the PhpStorm MCP skill to inspect this PHP project, apply safe quick fixes, and run the tests through the project interpreter.
```

```text
Use the PhpStorm MCP skill to rename this service method and verify every implementation and call site.
```

```text
Use the PhpStorm MCP skill to compare PhpStorm's PHP interpreter with Composer's runtime before running the test command.
```

```text
Use the PhpStorm MCP skill to decide whether this task should use PhpStorm inspections, a semantic refactor, or terminal commands.
```

## What Changes In The Agent

Without this skill, an agent may treat a PhpStorm project like plain files plus shell commands.

With this skill, the agent knows to:

- Ask PhpStorm for the active PHP interpreter and language level.
- Prefer semantic rename refactoring over text replacement.
- Use inspections and quick fixes before broad cleanup.
- Run simple PHP scripts through the project interpreter when that matters.
- Check Composer runtime mismatch before trusting Composer scripts.
- Fall back to terminal tools when exact shell behavior matters.
- Treat database writes and destructive IDE actions as approval-gated work.

## Install From A Release

Use one release asset:

- `phpstorm-mcp-vX.Y.Z.zip` for standalone skill installation.
- `phpstorm-mcp-codex-plugin-vX.Y.Z.zip` for Codex plugin installation.
- `phpstorm-mcp-claude-plugin-vX.Y.Z.zip` for Claude plugin installation.

See [docs/INSTALL.md](docs/INSTALL.md) for package layouts and installation notes.

## Runtime Skill Contents

- `src/SKILL.md` is the canonical runtime skill entry point.
- `src/references/` contains focused guidance loaded only when needed.

The packaged standalone skill contains only `SKILL.md` and runtime references.

## Best Fit

Use this skill for Symfony, Laravel, WordPress, Magento, custom PHP apps, Composer libraries, CLI tools, and any PHP codebase where PhpStorm has meaningful project configuration.

It is especially useful when the project has multiple PHP versions, Composer scripts, generated code, remote interpreters, Docker, WSL, SSH, Xdebug, database tooling, or framework-specific run configurations.

## Author And Maintainer

TechSpokes maintains this skill.

Website: [www.techspokes.com](https://www.techspokes.com)
