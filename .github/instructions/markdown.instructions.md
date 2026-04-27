---
applyTo: "**/*.md"
---

# Markdown Instructions

## Goal

Keep Markdown files readable by humans, AI agents, GitHub, IDEs, and simple tooling.

## Rules

- Use one H1 title per file.
- Maintain heading hierarchy without skipped levels.
- Use real headings instead of bold text as headings.
- Use short paragraphs.
- Use flat lists.
- Avoid nested lists.
- Use dashes for unordered lists.
- Use numbered lists only when order matters.
- Add language identifiers to fenced code blocks.
- Use `bash` for portable shell command fences.
- Use `text` for command output fences.
- Use `powershell` only when the command fence uses PowerShell-specific syntax.
- Use inline code spans for commands, tool names, exact CLI snippets, and identifiers when useful.
- Do not let inline code spans move to their own physical line.
- Avoid horizontal rules.
- Avoid em dash punctuation.
- Use relative links for repository files.
- Define specialized terms before relying on them.

## Rationale

Markdown in this repository is read by humans, AI agents, GitHub, IDEs, and validation tools. Structural Markdown survives across those readers better than visual formatting.
