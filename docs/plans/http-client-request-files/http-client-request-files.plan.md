# HTTP Client Request Files Implementation Plan

> For agentic workers: REQUIRED SUB-SKILL: Use `superpowers:subagent-driven-development` or `superpowers:executing-plans` to implement this plan task by task. Steps use checkbox syntax for tracking.

## Goal

Add clear runtime guidance for JetBrains HTTP Client request files so agents using the `phpstorm-mcp` skill can create, inspect, run, and report `.http` and `.rest` request workflows through PhpStorm MCP without leaking secrets or causing unapproved remote side effects.

## Architecture

Keep `src/SKILL.md` concise and route detailed HTTP Client behavior to a new focused reference file. Update existing execution, tool-selection, capability, safety, architecture, and maintenance documents only where they need to point to or classify the new request-file workflow.

## Tech Stack

- Runtime skill content under `src/SKILL.md` and `src/references/`.
- Repository maintenance docs under `docs/`.
- PhpStorm MCP tools including `search_file`, `open_file_in_editor`, `get_run_configurations`, `execute_run_configuration`, and `search_ide_actions`.
- JetBrains HTTP Client `.http` and `.rest` files, private environment files, response handlers, pre-request handlers, request variables, global variables, and response output redirects.
- Validation through `npm run validate`.

## Source Evidence

The source evidence includes a local repository example, a live disposable probe in this repository, and current JetBrains documentation. If the sibling example repository is available, start evidence review at `techspokes-track-channel-reviews/tests/api`.

Local example files to inspect:

- `techspokes-track-channel-reviews/tests/api/README.md`
- `techspokes-track-channel-reviews/tests/api/AGENTS.md`
- `techspokes-track-channel-reviews/tests/api/reviews-updated-since.http`
- `techspokes-track-channel-reviews/tests/api/reviews.http`
- `techspokes-track-channel-reviews/tests/api/single-review.http`
- `techspokes-track-channel-reviews/docs/local-api-probes.md`

The example repository keeps JetBrains HTTP Client probes under `tests/api/`. Its `tests/api/README.md` documents `get_run_configurations(filePath)` for discovering request run points, `execute_run_configuration(filePath,line)` for one request, saved `All in <file-base-name>` configurations for whole-file workflows, IDE-selected environments, response handlers that set `client.global`, `request.variables` for output path substitution, and `>>!` response capture paths under ignored results directories.

The example request files show real patterns the skill should teach: `@name=value` file variables, `http-client.private.env.json` for credentials, Basic authorization headers, response handler tests with `client.test` and `client.assert`, pagination through `client.global`, copying global values into `request.variables`, and saved response files such as `results/{{context}}/.../reviews-{{page}}.json`.

A live scratch probe in this repository on 2026-07-03 created `.scratches/http-client-runpoint-probe.http`. `get_run_configurations(filePath)` initially could not access the fresh ignored file, `search_file` with `includeExcluded: true` found it, `open_file_in_editor` made it IDE-visible, and `get_run_configurations(filePath)` then returned a `Run/Debug HTTP Request` run point at line 2. `execute_run_configuration(filePath,line)` returned exit code `0` with empty output, so guidance must tell agents to inspect saved response files and request history when stdout is empty.

JetBrains PhpStorm 2026.1 documentation describes physical HTTP request files as project files for documenting, testing, and validating requests. It documents IDE environment selection through the `Run with` list, response handlers with tests, sequential execution of all requests in a file, temporary and saved HTTP Request run configurations, automatic response storage under `.idea/httpRequests`, binary response handling, custom output redirects with `>>` and `>>!`, private environment files for secrets, request history, cookies, WebSocket requests, GraphQL requests, and SSL/TLS settings.

Official documentation map:

- Use https://www.jetbrains.com/help/phpstorm/http-client-in-product-code-editor.html for request-file creation, single-request execution, run-all execution, saved run configurations, response storage, `>>` and `>>!` output redirects, request history, cookies, WebSocket requests, GraphQL requests, binary responses, and SSL/TLS settings.
- Use https://www.jetbrains.com/help/phpstorm/http-client-variables.html for public and private environment files, variable precedence, `Run with` environment selection, in-place variables, per-request variables, and secret handling.
- Use https://www.jetbrains.com/help/phpstorm/http-response-handling-examples.html for response handler tests, `client.assert`, `client.global`, JSONPath, XPath, cookies, and streaming examples.
- Re-check these pages before implementation if PhpStorm or the HTTP Client plugin version has changed since 2026-07-03.

## Current State

`src/SKILL.md` already tells agents to use `execute_run_configuration(filePath,line)` for simple file execution, but it does not name JetBrains HTTP Client request files or explain their environment, output, state, and safety behavior.

`src/references/refactoring-and-execution.md` covers generic file execution but does not distinguish `.http` and `.rest` run points, saved `All in <file-base-name>` configurations, or response-file verification.

`src/references/capability-matrix.md` records generic `get_run_configurations` and `execute_run_configuration` behavior, but it does not capture observed HTTP request-file behavior or the empty-stdout result from HTTP execution.

`src/references/database-and-ide-actions.md` classifies database and broad IDE actions as high-risk, but it does not classify remote HTTP requests, downloads, uploads, credentialed requests, response-file writes, disabled certificate verification, or debug HTTP runs.

`docs/MAINTENANCE-CAPABILITY-SWEEP.md` does not include an HTTP Client request-file probe.

## Target State

Agents using this skill can recognize `.http` and `.rest` files as first-class PhpStorm MCP execution targets.

Agents can create durable static request files for approved API probes, smoke checks, response captures, and file downloads when a reusable request artifact is better than a one-off shell command.

Agents can discover request run points with `get_run_configurations(filePath)`, execute approved request entries with `execute_run_configuration(filePath,line)`, and run whole-file workflows through saved HTTP Request run configurations when available.

Agents understand that current MCP execution does not expose a direct HTTP Client environment selector, so they must confirm the IDE-selected `Run with` environment before running environment-dependent requests.

Agents treat HTTP Client request execution as high-risk when it is remote, credentialed, mutating, uploading, downloading, writing files, disabling TLS verification, using private environment files, using cookies, opening WebSockets, or starting PHP debug sessions.

Agents report method, target, selected environment, run target, exit code, response status or test results when available, saved output paths, and any uncertainty caused by empty MCP stdout.

## Files

- Create `src/references/http-client-request-files.md`.
- Modify `src/SKILL.md`.
- Modify `src/references/tool-selection.md`.
- Modify `src/references/refactoring-and-execution.md`.
- Modify `src/references/capability-matrix.md`.
- Modify `src/references/database-and-ide-actions.md`.
- Modify `docs/MAINTENANCE-CAPABILITY-SWEEP.md`.
- Modify `docs/ARCHITECTURE.md`.
- Modify `README.md` only if maintainers want the public project overview to mention HTTP Client request-file support.
- Modify `CHANGELOG.md` and add `docs/releases/vX.Y.Z.md` only when this runtime guidance ships in a release.

## Task 1: Add The Runtime HTTP Client Reference

### Step 1: Create The Reference File

- [ ] Create `src/references/http-client-request-files.md` with the content below.

````markdown
# HTTP Client Request Files

Use this reference when the task involves JetBrains HTTP Client `.http` or `.rest` files.

## Purpose

HTTP request files are reusable IDE-owned API probes. Use them when a request should remain as a project artifact, when response handlers should validate behavior, when a workflow should run multiple requests in order, or when a response body or downloaded file should be saved for inspection.

Do not treat HTTP request files as harmless tests. They can send credentials, mutate remote systems, upload data, download files, write response bodies, store cookies, use TLS settings, open WebSocket connections, and start PHP debug sessions.

## Official Documentation

Use JetBrains HTTP Client documentation when authoring or troubleshooting request files.

Use https://www.jetbrains.com/help/phpstorm/http-client-in-product-code-editor.html for request syntax, request-file creation, single-request execution, run-all execution, saved run configurations, response storage, output redirects, request history, cookies, WebSocket requests, GraphQL requests, binary responses, and SSL/TLS settings.

Use https://www.jetbrains.com/help/phpstorm/http-client-variables.html for public and private environment files, variable precedence, `Run with` environment selection, in-place variables, per-request variables, and secret handling.

Use https://www.jetbrains.com/help/phpstorm/http-response-handling-examples.html for response handler tests, `client.assert`, `client.global`, JSONPath, XPath, cookies, and streaming examples.

## Before Creating Or Running Requests

Confirm the target environment, host, method, credentials, and output path before execution.

Read the request file, nearby `http-client.env.json`, nearby `http-client.private.env.json` references, `.gitignore`, and local agent instructions before running a credentialed or output-writing request.

Ask the user to select the intended HTTP Client environment in PhpStorm when the request uses environment variables. Current MCP execution does not expose a direct HTTP Client environment parameter.

Require explicit approval before running remote, credentialed, mutating, upload, download, response-writing, TLS-verification-disabled, cookie-dependent, WebSocket, or debug HTTP requests.

## Discovery Workflow

Use `search_file` with `includeExcluded: true` or terminal `rg --files -uu -g "*.http" -g "*.rest"` to find request files, because local API probes are often ignored.

Use `open_file_in_editor` before run-point discovery when a request file is fresh, ignored, or not yet visible to PhpStorm indexing.

Call `get_run_configurations` with `filePath` before running by line. Use the returned run-point line numbers instead of assuming request line numbers.

Call `get_run_configurations` without `filePath` to discover saved HTTP Request configurations such as `All in <file-base-name>`.

Use `search_ide_actions` only for capability discovery when direct MCP tools or saved run configurations do not cover the workflow.

## Execution Workflow

Run one approved request with `execute_run_configuration(filePath,line)`.

Run a whole-file workflow with `execute_run_configuration(configurationName)` when a saved HTTP Request configuration exists and the user approved the whole file.

Prefer saved whole-file configurations for workflows where earlier response handlers populate `client.global` values consumed by later requests.

Do not pass dynamic launch overrides such as `programArguments`, `workingDirectory`, or `envs` unless the selected run configuration reports `supportsDynamicLaunchOverrides: true`.

Treat empty MCP output as inconclusive. Inspect saved response files, custom output paths, request history, tests reported by the IDE, or generated artifacts before claiming a request succeeded.

## Request Authoring Rules

Use `.http` or `.rest` files for durable request workflows. Use ignored scratch directories for disposable probes that may contain private endpoints, credentials, or response captures.

Keep credentials, tokens, client certificates, private hosts, and customer-specific values in `http-client.private.env.json` or an approved secret store. Ensure private environment files are ignored by terminal Git workflows.

Use file variables for safe defaults that can be shared, such as page size or fixture identifiers.

Use environment variables for hosts and secrets that vary by target environment.

Use pre-request handlers for derived request variables, signatures, timestamps, and output path segments.

Use response handlers with `client.test` and `client.assert` when the request is intended to validate an endpoint.

Use `client.global` only for values that must survive across later requests in the same IDE session.

Copy any `client.global` value into `request.variables` before using it in request URLs, headers, bodies, or `>>` and `>>!` output paths.

Prefer output paths inside ignored probe directories unless the user explicitly wants a sanitized fixture committed.

## Examples

Use a harmless local request for capability probes.

```http
### MCP HTTP Client runpoint probe
GET http://127.0.0.1:9/__phpstorm_mcp_http_probe__
Accept: application/json
```

Use response handlers when a request is intended to validate an endpoint.

```http
### Validate approved local health endpoint
GET http://127.0.0.1:18080/health
Accept: application/json

> {%
    client.test("Status code is 200", function () {
        client.assert(response.status === 200);
    });
%}
```

Use `>>!` only when overwriting the output file is intended and approved.

```http
### Download approved local fixture
GET http://127.0.0.1:18080/fixture.json
Accept: application/json

>>! .\results\fixture.json
```

Use `client.global` for state shared by later requests, then copy values into `request.variables` before output-path substitution.

```http
@size=100
### First page
GET {{host}}/api/items?page=1&size={{size}}
Accept: application/json

> {%
    client.test("Status code is 200", function () {
        client.assert(response.status === 200);
    });
    client.global.set("itemPage", [1, 2]);
%}

>>! .\results\items-1.json

### Follow-up pages
< {%
    const itemPage = client.global.get("itemPage") || [];
    if (itemPage.length === 0) {
        throw new Error("No item pages found");
    }
    request.variables.set("itemPage", itemPage);
%}
GET {{host}}/api/items?page={{itemPage}}&size={{size}}
Accept: application/json

>>! .\results\items-{{itemPage}}.json
```

## Output And Downloads

JetBrains HTTP Client automatically stores recent responses and request history under `.idea/httpRequests`.

Use `>>` when repeated runs should preserve older response files with suffixes.

Use `>>!` only when overwriting the target file is intended and approved.

Classify explicit response output paths as file writes. Classify binary responses and large response bodies as downloads.

After execution, report saved custom output paths and whether those paths are tracked, ignored, or private.

## Risk Classification

Low-risk requests are local, read-only, unauthenticated, do not write files outside an ignored scratch area, and target disposable services.

High-risk requests include non-local hosts, production or customer hosts, credentials, `Authorization` headers, cookies, mutating HTTP methods, uploads, downloads, response output writes, TLS verification changes, private environment files, WebSocket sessions, GraphQL mutations, and PHP debug launches.

For every high-risk request, record the approved target, method, environment, output path, before evidence, execution result, after evidence, and cleanup or rollback path when applicable.

## Reporting

Report the selected environment, request file, request line or configuration name, method, sanitized target, exit code, response status when available, test result when available, saved response paths, and any uncertainty.

Never paste credentials, tokens, private environment values, raw customer data, guest names, reservation numbers, or proprietary response bodies into reusable output.
````

### Step 2: Review The New Reference

- [ ] Confirm the new reference has exactly one H1, no skipped heading levels, no nested lists, no bold labels, and no em dash punctuation.

### Step 3: Confirm The Reference Boundary

- [ ] Confirm the new reference contains runtime guidance only and does not include absolute local paths, raw private API responses, credentials, or the names of local customer data files.

## Task 2: Wire The Reference Into The Skill Entry Point

### Step 1: Update The Skill Description If Needed

- [ ] In `src/SKILL.md`, update the frontmatter description only if the current trigger text does not make HTTP Client request-file tasks discoverable.

Suggested folded description:

```yaml
description: Use when Codex is working in a project opened in PhpStorm and should decide how to use PhpStorm MCP tools for project configuration, search, inspections, quick fixes, formatting, symbol refactoring, execution, HTTP Client request files, Composer or PHP checks when present, database probes, IDE action discovery, or validation. Use to route between IDE-owned semantic context and terminal tools while avoiding unsafe or low-observability IDE actions.
```

### Step 2: Update When To Use

- [ ] In `src/SKILL.md`, add these bullets to `When To Use`.

```markdown
- Create, review, or run JetBrains HTTP Client `.http` or `.rest` request files.
- Capture response bodies or download files through approved HTTP Client request workflows.
```

### Step 3: Update When Not To Use

- [ ] In `src/SKILL.md`, add this paragraph to `When Not To Use`.

```markdown
Do not run credentialed, remote, mutating, upload, download, response-writing, WebSocket, TLS-verification-disabled, or debug HTTP Client requests unless the user approves the target, method, environment, and output scope.
```

### Step 4: Update Core Workflow

- [ ] In `src/SKILL.md`, add an HTTP Client step after run-configuration discovery.

```markdown
3. For `.http` or `.rest` request files, load `http-client-request-files.md`, inspect environment and output scope, classify risk, and discover request run points with `get_run_configurations(filePath)`.
```

- [ ] Renumber the remaining workflow steps without changing their meaning.

### Step 5: Update Tool Routing

- [ ] In `src/SKILL.md`, add this sentence to `Tool Routing`.

```markdown
Use PhpStorm MCP for HTTP Client request-file run points and saved HTTP Request configurations. Use terminal tools such as `curl` only when exact stdout, scriptable flags, CI reproduction, or shell-level control matters more.
```

### Step 6: Update Reference Loading

- [ ] In `src/SKILL.md`, add this bullet to `Reference Loading`.

```markdown
- [http-client-request-files.md](references/http-client-request-files.md) for JetBrains HTTP Client `.http` and `.rest` request files, response captures, downloads, and request execution safety.
```

### Step 7: Update Safety Rules

- [ ] In `src/SKILL.md`, add HTTP Client risks to the existing high-risk sentence.

Suggested sentence:

```markdown
Classify database writes, schema changes, imports, exports, dependency install or update actions, delete actions, safe delete, code cleanup, Docker prune, VCS removal, debug-state toggles, credentialed HTTP requests, remote mutating HTTP requests, uploads, downloads, response output writes, and TLS-verification-disabled HTTP requests as high-risk.
```

## Task 3: Update Focused References

### Step 1: Update Tool Selection

- [ ] In `src/references/tool-selection.md`, add this routing choice after the `execute_run_configuration(filePath,line)` guidance.

```markdown
Use PhpStorm MCP for JetBrains HTTP Client `.http` and `.rest` request files when the request should be a reusable IDE artifact, needs HTTP Client environments, uses response handlers, runs sequential request workflows, or saves response bodies. Fall back to terminal tools such as `curl` when exact stdout, portable CI execution, custom shell flags, or process control matters more.
```

- [ ] In `src/references/tool-selection.md`, add these decision questions.

```markdown
- Is an HTTP request file safer and more reusable than a one-off shell command?
- Is the request remote, credentialed, mutating, downloading, uploading, writing output, or using a private environment file?
- Has the user selected and confirmed the intended HTTP Client environment in PhpStorm?
```

### Step 2: Update Refactoring And Execution

- [ ] In `src/references/refactoring-and-execution.md`, add this section after `Simple File Execution`.

```markdown
## HTTP Client Request Execution

Load `http-client-request-files.md` before creating, editing, or running JetBrains HTTP Client `.http` or `.rest` files.

Use `get_run_configurations(filePath)` to discover request run points before executing by line.

Use `execute_run_configuration(filePath,line)` for one approved request run point.

Use a saved HTTP Request run configuration for whole-file workflows when one is listed by `get_run_configurations`.

Treat empty MCP output as inconclusive for HTTP requests. Verify saved response files, custom output paths, request history, or response handler test results before reporting success.
```

### Step 3: Update Capability Matrix

- [ ] In `src/references/capability-matrix.md`, add or revise rows so these observations are recorded.

```markdown
| `get_run_configurations(filePath)` for HTTP files | Returned `Run/Debug HTTP Request` run points for an IDE-visible `.http` file in a disposable probe. | Recommended for line discovery before running HTTP Client request files. |
| `execute_run_configuration(filePath,line)` for HTTP files | Executed a disposable `.http` run point and returned exit code `0` with empty output. | Treat execution as callable but verify response files, request history, or handler tests before claiming success. |
| `search_file` with `includeExcluded` | Found a fresh ignored `.http` scratch file that older glob discovery did not find. | Prefer for local probe files that may be ignored or newly created. |
| HTTP Client IDE actions | `search_ide_actions` exposed HTTP Client creation, conversion, collection, environment, and history actions in live discovery. | Treat as discovery-only unless a direct MCP tool or saved run configuration cannot cover the task. |
```

### Step 4: Update Database And IDE Actions

- [ ] In `src/references/database-and-ide-actions.md`, add this section before `IDE Action Discovery`.

```markdown
## HTTP Request Side Effects

Classify remote, credentialed, mutating, upload, download, response-writing, TLS-verification-disabled, WebSocket, GraphQL mutation, and debug HTTP Client requests as high-risk.

Before running a high-risk HTTP Client request, require:

- Explicit user approval for the exact target.
- The selected HTTP Client environment.
- The HTTP method and request file or run configuration.
- The output path for any saved response or download.
- A rollback or cleanup plan when the remote action can mutate state.
- A verification plan that does not expose private response bodies.

Prefer local disposable hosts for capability probes. Do not use production or customer endpoints to test the skill itself.
```

- [ ] Add `HTTP Client remote, credentialed, mutating, upload, download, and response-writing actions` to the `High-Risk Action Families` list.

## Task 4: Update Maintenance And Repository Documentation

### Step 1: Update The Capability Sweep

- [ ] In `docs/MAINTENANCE-CAPABILITY-SWEEP.md`, update `Test Area` to allow ignored `.scratches/` probes when a user approves that location.

Suggested addition:

```markdown
- Use `.scratches/` for user-approved throwaway probes when the repository ignores that directory.
```

- [ ] In `docs/MAINTENANCE-CAPABILITY-SWEEP.md`, add this required sweep item after execution testing.

```markdown
9. Test JetBrains HTTP Client `.http` run-point discovery with a disposable local request file, then test execution only against a local disposable endpoint or an intentionally unreachable localhost URL.
```

- [ ] Renumber the remaining sweep items.

### Step 2: Add The Disposable HTTP Probe Procedure

- [ ] In `docs/MAINTENANCE-CAPABILITY-SWEEP.md`, add this section before `Prohibited By Default`.

````markdown
## HTTP Client Probe

Use an ignored probe file such as `.scratches/http-client-capability-lab.http` or `tmp/ide-capability-lab/http-client-capability-lab.http`.

Start with an intentionally harmless local request:

```http
### MCP HTTP Client runpoint probe
GET http://127.0.0.1:9/__phpstorm_mcp_http_probe__
Accept: application/json
```

Run `search_file` with `includeExcluded: true`, then `open_file_in_editor` if the file is fresh or ignored.

Run `get_run_configurations(filePath)` and record whether a `Run/Debug HTTP Request` run point appears.

Run `execute_run_configuration(filePath,line)` only if the target is local and disposable. Record exit code, output shape, request history behavior, generated files, and `git status --short`.

Use a local throwaway HTTP server for download or `>>!` output-path testing. Do not use remote servers, private APIs, or production data for capability sweeps.
````

### Step 3: Update Architecture

- [ ] In `docs/ARCHITECTURE.md`, add `http-client-request-files.md` to the runtime reference list.

Suggested bullet:

```markdown
- `http-client-request-files.md` for JetBrains HTTP Client request files, response capture, downloads, and request execution safety.
```

### Step 4: Decide Whether README Needs A Public Mention

- [ ] If maintainers want the repository overview to advertise this capability, add a short README sentence that mentions JetBrains HTTP Client request-file guidance.

Suggested sentence:

```markdown
The skill also covers JetBrains HTTP Client `.http` and `.rest` request files, including request run-point discovery, response capture, downloads, environment selection, and high-risk request safety.
```

## Task 5: Validate With A Disposable Local Probe

### Step 1: Confirm Scratch Ignore State

- [ ] Run `git check-ignore .scratches/http-client-capability-lab.http`.

Expected output:

```text
.scratches/http-client-capability-lab.http
```

- [ ] If `.scratches/` is not ignored, add it to `.gitignore` before creating disposable probe files.

### Step 2: Create A Disposable Probe

- [ ] Create `.scratches/http-client-capability-lab.http` with this content.

```http
### MCP HTTP Client runpoint probe
GET http://127.0.0.1:9/__phpstorm_mcp_http_probe__
Accept: application/json
```

### Step 3: Verify Discovery Through MCP

- [ ] Run `search_file` with `q: "*.http"`, `paths: [".scratches/**"]`, and `includeExcluded: true`.

Expected result:

```text
.scratches/http-client-capability-lab.http appears in the result set.
```

- [ ] Run `open_file_in_editor` for `.scratches/http-client-capability-lab.http` if `get_run_configurations(filePath)` cannot access the file.

- [ ] Run `get_run_configurations(filePath)` for `.scratches/http-client-capability-lab.http`.

Expected result:

```text
The response contains at least one run point with a description equivalent to Run/Debug HTTP Request.
```

### Step 4: Verify Execution Shape

- [ ] Run `execute_run_configuration(filePath,line)` against the discovered local run point with a short timeout.

Expected result:

```text
The command returns a structured execution result. Empty output is acceptable if the result includes an exit code or timeout state.
```

- [ ] Record whether output, exit code, request history, or generated files are available.

- [ ] Run `git status --short`.

Expected output:

```text
No tracked files changed except intentional documentation edits and `.gitignore` when `.scratches/` had to be added.
```

### Step 5: Optionally Verify A Local Download

- [ ] Use a local throwaway HTTP server if maintainers want to prove `>>!` response output behavior during implementation.

- [ ] Keep all generated download outputs under `.scratches/` or `tmp/ide-capability-lab`.

- [ ] Do not use remote servers or private APIs for this validation step.

Example request content:

```http
### Download local fixture through JetBrains HTTP Client
GET http://127.0.0.1:18080/fixture.json
Accept: application/json

> {%
    client.test("Status code is 200", function () {
        client.assert(response.status === 200);
    });
%}

>>! .\results\fixture.json
```

## Task 6: Run Repository Validation

### Step 1: Run Markdown-Focused Search Checks

- [ ] Run `rg -n "TO[D]O|TB[D]|INSER[T]|placeholde[r]" src README.md CHANGELOG.md docs/ARCHITECTURE.md docs/MAINTENANCE-CAPABILITY-SWEEP.md docs/releases`.

Expected output:

```text
No unresolved marker text appears in the files changed by this plan.
```

- [ ] Run `rg -n "C:\\\\User[s]|http-client.private.env.json.*passwor[d]|Authorizatio[n]: Basic [^{}]" src README.md docs/ARCHITECTURE.md docs/MAINTENANCE-CAPABILITY-SWEEP.md docs/releases`.

Expected output:

```text
No local absolute paths, copied private environment values, or concrete Basic credentials appear in reusable docs.
```

### Step 2: Run Repository Validation

- [ ] Run `npm run validate`.

Expected output:

```text
Validation passed.
```

### Step 3: Inspect Git Diff

- [ ] Run `git diff --check`.

Expected output:

```text
No whitespace errors.
```

- [ ] Run `git status --short`.

Expected output:

```text
Only the intended documentation, runtime reference, and optional `.gitignore` changes are present.
```

## Acceptance Criteria

- `src/SKILL.md` triggers and routes HTTP Client request-file tasks without becoming a long tool manual.
- `src/references/http-client-request-files.md` gives complete runtime guidance for discovery, execution, environments, output, downloads, risk classification, and reporting.
- Existing references point to the new file instead of duplicating its full guidance.
- High-risk guidance covers remote hosts, credentials, mutating methods, uploads, downloads, response-file writes, private environment files, TLS verification changes, cookies, WebSockets, GraphQL mutations, and debug HTTP sessions.
- The maintenance sweep includes a disposable HTTP Client probe that can be repeated without private APIs or remote side effects.
- Validation evidence includes MCP run-point discovery for an ignored scratch `.http` file and `npm run validate`.
- Reusable skill content contains no credentials, raw private responses, local absolute paths, or customer-specific data.

## Release Notes

When this ships, add a `CHANGELOG.md` entry stating that the skill now covers JetBrains HTTP Client request files, response captures, downloads, environment confirmation, MCP run-point execution, and HTTP request safety classification.

When cutting a real release, add a `docs/releases/vX.Y.Z.md` note with the same user-facing capability summary.
