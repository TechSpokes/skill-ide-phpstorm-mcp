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

Read the request file, nearby public `http-client.env.json` files, `.gitignore`, and local agent instructions before running a credentialed or output-writing request.

For nearby `http-client.private.env.json` files, inspect only the file path, ignore status, environment names, and key names by default. Do not read, paste, summarize, or retain private values unless the user explicitly approves secret inspection for the active task.

Ask the user to select the intended HTTP Client environment in PhpStorm when the request uses environment variables. Current MCP execution does not expose a direct HTTP Client environment parameter.

Require explicit approval before running remote, credentialed, mutating, upload, download, response-writing, TLS-verification-disabled, cookie-dependent, WebSocket, GraphQL mutation, or debug HTTP requests.

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
