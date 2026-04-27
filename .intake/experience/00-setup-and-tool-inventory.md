# Setup and Tool Inventory

## Intake boundary

The work in this phase stays under `.intake/` because `.intake/goal.md` explicitly says not to start the skill build phase yet.

## MCP endpoint

`.intake/.mcp.json` defines a streamable HTTP server at `http://127.0.0.1:64735/stream`. The PhpStorm MCP tools are available in this session, so the endpoint is usable from Codex.

## PhpStorm project configuration found through MCP

### Initial observation

- Project path: `C:\Users\serge\PhpstormProjects\skill-ide-phpstorm-mcp`
- PhpStorm language level: `5.6.0`
- PHP interpreter: `C:\wamp64\bin\php\php8.1.26\php.exe`
- Runtime version: `8.1.26`
- Debugger: Xdebug `3.2.2`
- Existing run configurations: none

### Updated observation after project config changed

- Project path: `C:\Users\serge\PhpstormProjects\skill-ide-phpstorm-mcp`
- PhpStorm language level: `8.2`
- PHP interpreter: `C:\wamp64\bin\php\php8.2.29\php.exe`
- Runtime version: `8.2.29`
- Debugger: Xdebug `3.4.4`
- Existing run configurations at initial discovery: none

This reinforces the skill-design point that agents should call `get_php_project_config` during the active task, not rely on stale notes or shell defaults.

## Tool groups visible from MCP

- Project configuration: PHP language level, interpreter, runtime, extensions, debugger.
- File discovery: filename search, glob search, indexed text search, indexed regex search.
- Code intelligence: inspections, quick fixes, formatting, symbol rename refactoring.
- Execution: IDE run configurations and IDE integrated terminal commands.
- IDE UI actions: open file, invoke/search actions.

## Current implication

Terminal tools remain better for raw file reads, exact command output, and repository-wide shell automation. MCP has clear unique value for IDE-only state, configured PHP runtime details, inspections, formatting, and symbol-safe refactors. Project config can change during a session, so runtime-sensitive choices must be refreshed before applying syntax or type quick fixes.
