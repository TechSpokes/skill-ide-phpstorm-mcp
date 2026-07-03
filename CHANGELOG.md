# Changelog

## [Unreleased]

No unreleased changes.

## [v1.4.0]

- Add runtime guidance for JetBrains HTTP Client `.http` and `.rest` request files.
- Cover request run-point discovery, saved HTTP Request configurations, response captures, downloads, environment confirmation, and empty-output verification.
- Classify high-risk HTTP Client requests, including remote, credentialed, mutating, upload, download, response-writing, TLS-verification-disabled, cookie, WebSocket, GraphQL mutation, and debug workflows.
- Add a repeatable disposable HTTP Client capability sweep and prepare v1.4.0 release package metadata.

## [v1.3.0]

- Add a README quick install path that points users to the latest GitHub release and explains which ZIP asset to choose.
- Expand install documentation with direct latest-release guidance, exact standalone extraction targets, plugin package notes, and an after-install example request.
- Align the package release script with the repository's Node global inspection directive pattern.
- Prepare v1.3.0 release package metadata.

## [v1.2.0]

- Add required plugin manifest metadata and validation for license fields and Claude display name.
- Skip stub files and prune empty directories during release packaging.
- Update install documentation with current standalone skill locations.
- Correct release workflow smoke-test tag guidance, changelog checks, and checkout version history.
- Make `docs/RELEASING.md` the single source for repository change and release workflow guidance.
- Add a local template-feedback convention for upstream template improvement notes.
- Apply and document GitHub repository hardening settings, including squash-only merging, repository admin bypass, and the `main protection` ruleset.
- Document and suppress a known PhpStorm inspection false positive for `actions/setup-node@v6`.

## [v1.1.0]

- Update CI and release workflows to use `actions/checkout@v7`.
- Update CI and release workflows to use `actions/setup-node@v6`.
- Prepare v1.1.0 release package metadata.

## [v1.0.2]

- Update Codex and Claude plugin manifests to describe PhpStorm projects instead of PHP-only projects.
- Add JetBrains plugin metadata keyword for marketplace discovery.
- Prepare v1.0.2 release package metadata.

## [v1.0.1]

- Rework the README around concrete PHP developer workflow problems.
- Add maintainer adoption research guidance in `docs/ADOPTION-RESEARCH.md`.
- Clarify that PhpStorm MCP tool availability can vary by schema.
- Clarify that IDE diagnostics should run before tests for most edits.
- Clarify that PhpStorm projects may be non-PHP and PHP-specific checks should run only when relevant.

## [v1.0.0]

- Prepare the first public release of the TechSpokes `phpstorm-mcp` skill.
- Publish runtime guidance for PhpStorm MCP tool routing.
- Cover inspections, quick fixes, refactoring, execution, Composer, databases, and IDE actions.
- Publish focused runtime references for installed skill users.
- Move capability sweep guidance to repository maintenance documentation.
- Confirm release packaging excludes raw intake, bootstrap files, local fixtures, and docs.
- Set TechSpokes as the skill author and maintainer.
