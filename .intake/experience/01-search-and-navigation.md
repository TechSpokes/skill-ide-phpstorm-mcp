# Search and Navigation Findings

## Scenario

Find the `TaskService` class, the active-task listing method, and every call site in the sample app.

## Terminal path

- `rg 'listOpenTasks|TaskService|Focus Ledger' .intake\app`
- Result: immediate matches across PHP and Markdown files.
- Measured elapsed time for one search: about 55 ms.
- Strength: excellent for broad text search, exact output, count-oriented queries, and context flags.
- Limitation: plain text cannot distinguish a method declaration from a method call without additional parsing.

## MCP path

- `find_files_by_glob` found all `.php` files under `.intake/app`.
- `find_files_by_name_keyword` found `Task.php`, `TaskRepository.php`, `TaskService.php`, and `tasks.json`.
- `search_in_files_by_text` found all method call sites with line numbers and highlighted matches.
- `search_in_files_by_regex` found the `TaskService` class declaration.
- Typical observed tool latency was sub-second.

## Caveat

The newer `search_text` tool returned no hits for `listOpenTasks` in `.intake/app`, while `search_in_files_by_text` worked correctly. Future skill guidance should prefer the established PhpStorm search tools until this behavior is better understood.

## Efficiency judgment

Use MCP for IDE-indexed project search when line-numbered results and project exclusions matter. Use terminal `rg` for raw speed, context windows, counts, compound shell workflows, and checking freshly generated files when index freshness is uncertain.
