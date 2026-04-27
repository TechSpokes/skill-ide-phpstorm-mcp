# Search And Indexing

Use this reference for PhpStorm MCP search behavior and terminal fallback.

## Search Order

Use `search_file` for compact file coordinates and project-aware path filtering.

Use `search_text` for compact text coordinates when indexing is current.

Use `search_in_files_by_text` when highlighted line snippets are useful.

Use `search_in_files_by_regex` for declaration-style regex searches.

Use `rg` or an equivalent terminal search when files were just generated, context lines are needed, or MCP search results are missing.

## Fresh File Behavior

PhpStorm indexing can lag behind newly generated files. A missed IDE search result is not proof that the file does not exist.

When a fresh file is missing from one search surface:

1. Try another MCP search surface.
2. Open or locate the file through `open_file_in_editor` or `search_file` when useful.
3. Verify with `rg --files` or equivalent terminal discovery.
4. Retry IDE search after the IDE becomes aware of the file.

## Result Interpretation

Treat `find_files_by_name_keyword` as broad discovery because it may return directories as well as files.

Treat `find_files_by_glob` as useful but index-sensitive.

Prefer `rg` when a task needs surrounding context, raw speed, excluded-directory awareness, or exact regular expression behavior.

## Verification

After search-driven edits, verify that old and new names or patterns match expectations with both MCP search and terminal search when the edit affects code behavior.
