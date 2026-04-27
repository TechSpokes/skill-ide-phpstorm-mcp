# PhpStorm MCP Skill

`phpstorm-mcp` helps coding agents use the same PhpStorm project context developers rely on.

PhpStorm is often used for PHP projects, mixed repositories, frontend applications, documentation sites, and tooling projects. Those projects still depend on IDE-owned context: configured runtimes, framework indexing, inspections, formatter rules, run configurations, database connections, and symbol graphs. When an agent sees only files and a shell, it can pick the wrong runtime, miss framework conventions, rename code by text, or make broad edits without enough evidence.

This skill gives the agent a practical rule: use PhpStorm MCP for IDE-owned semantic context, then use terminal tools for exact commands, raw output, fresh file scans, and process control.

## Why This Exists

Coding agents are useful in PhpStorm projects only when they work from the same project context as the developer.

That context often lives in PhpStorm: custom frameworks, package constraints, Laravel or Symfony conventions, WordPress and Magento structure, JavaScript and frontend tooling, test runners, static analysis tools, remote interpreters, Docker, WSL, SSH, and local database tooling. Developers also need explicit control over changes that can affect dependencies, databases, cleanup, formatting, VCS state, or generated files.

PhpStorm already tracks much of that project knowledge. `phpstorm-mcp` tells agents when to ask the IDE, when to verify in the terminal, and when to stop for approval.

## What It Improves

- Agents start from active PhpStorm project context.
- Runtime-sensitive work accounts for project runtimes, package managers, and interpreter differences.
- Search combines IDE-aware context with terminal fallback.
- Diagnostics start with PhpStorm inspections before tests or broad cleanup.
- Code symbol renames use semantic refactoring instead of text replacement when supported.
- Tests and scripts can follow the project runtime when the IDE defines one.
- High-risk work stays approval-gated and scoped.
- Validation uses more than one signal before reporting success.

## Best Fit

Use this skill when a project is open in PhpStorm and the IDE knows things an external agent may not know.

It is especially useful for:

- Laravel, Symfony, WordPress, Magento, Composer libraries, CLI tools, and custom apps.
- JavaScript, TypeScript, frontend, documentation, and tooling projects opened in PhpStorm.
- Mature or proprietary codebases with project-specific architecture.
- Projects with remote interpreters, Docker, WSL, SSH, Xdebug, or generated code.
- Teams that want IDE diagnostics before terminal verification.

## Example Requests

```text
Use the PhpStorm MCP skill to inspect this project, fix only low-risk issues, and verify the result with IDE diagnostics before tests.
```

```text
Use the PhpStorm MCP skill to rename this service method semantically and check every implementation and call site.
```

```text
Use the PhpStorm MCP skill to compare the PhpStorm interpreter, Composer runtime, and test command before changing code.
```

```text
Use the PhpStorm MCP skill in this TypeScript project to inspect warnings, use IDE search, and validate with the project test command.
```

```text
Use the PhpStorm MCP skill to decide whether this task needs IDE inspections, semantic refactoring, or terminal commands.
```

## How It Works

The installed skill contains one entry point and focused references.

- `src/SKILL.md` tells the agent when to use PhpStorm MCP and how to route work.
- `src/references/` contains task-specific guidance for search, inspections, quick fixes, refactoring, execution, Composer when present, database safety, and IDE actions.

The guidance is intentionally conservative. PhpStorm MCP capabilities can vary by IDE version, enabled plugins, client, and project type, so the agent refreshes live project state and validates mutations instead of assuming a fixed setup.

## Install From A Release

Use one release asset:

- `phpstorm-mcp-vX.Y.Z.zip` for standalone skill installation.
- `phpstorm-mcp-codex-plugin-vX.Y.Z.zip` for Codex plugin installation.
- `phpstorm-mcp-claude-plugin-vX.Y.Z.zip` for Claude plugin installation.

See [docs/INSTALL.md](docs/INSTALL.md) for package layouts and installation notes.

## Package Boundary

Release packages contain only runtime skill files and plugin manifests.

They exclude intake material, raw research, local paths, private credentials, disposable fixtures, repository documentation, workflows, temporary output, and distribution folders.

## Maintainer

TechSpokes maintains this skill.

Website: [www.techspokes.com](https://www.techspokes.com)
