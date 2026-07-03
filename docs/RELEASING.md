# Releasing

## Purpose

This document is the single source for how changes land in this repository and how releases are cut. Keep detailed release workflow instructions here so agent instructions, contribution docs, and pull request templates can link to one maintained process.

## How Changes Land

Every change should land through a pull request into `main`.

The normal flow is:

1. Create a branch from `main`.
2. Make the change and run `npm run validate`.
3. Run `npm run package -- v0.0.0` when packaging or release behavior changed.
4. Push the branch and open a pull request into `main`.
5. Wait for the `Validate skill package` check to pass.
6. Resolve review conversations.
7. Squash-merge the pull request.

## Main Protection

The default branch should be protected by repository rules or branch protection. Direct pushes to `main`, force pushes, branch deletion, and non-linear history should be blocked when the repository host supports those controls.

The required status check should be named `Validate skill package`, which is the CI job in `.github/workflows/ci.yml`.

## GitHub Repository Configuration

The GitHub repository settings in this section were applied on 2026-07-03 with the GitHub CLI against `TechSpokes/skill-ide-phpstorm-mcp`.

Future agents must verify the live settings before changing them. Do not rerun the hardening commands or create another ruleset unless verification shows drift or the user explicitly asks for a reconfiguration.

Verify the current state with:

```bash
gh api repos/TechSpokes/skill-ide-phpstorm-mcp --jq '{has_projects,has_wiki,has_discussions,allow_squash_merge,allow_merge_commit,allow_rebase_merge,delete_branch_on_merge,security_and_analysis}'
gh api repos/TechSpokes/skill-ide-phpstorm-mcp/rulesets
```

The expected repository state is:

- Discussions enabled.
- Projects disabled.
- Wiki disabled.
- Squash merge enabled.
- Merge commits disabled.
- Rebase merges disabled.
- Delete branch on merge enabled.
- Secret scanning enabled.
- Secret scanning push protection enabled.
- Dependabot security updates enabled.
- One active ruleset named `main protection` targeting the default branch.

Use the following commands only to repair drift or rebuild settings on a replacement repository.

The repository should use squash merges, delete branches after merge, keep Discussions enabled, and keep Projects and Wiki disabled:

```bash
gh api repos/TechSpokes/skill-ide-phpstorm-mcp -X PATCH -F has_discussions=true -F has_projects=false -F has_wiki=false -F allow_squash_merge=true -F allow_merge_commit=false -F allow_rebase_merge=false -F delete_branch_on_merge=true
```

Enable secret scanning and push protection when the repository plan supports those features:

```bash
gh api repos/TechSpokes/skill-ide-phpstorm-mcp -X PATCH -F security_and_analysis[secret_scanning][status]=enabled -F security_and_analysis[secret_scanning_push_protection][status]=enabled
```

Enable Dependabot alerts and security updates:

```bash
gh api repos/TechSpokes/skill-ide-phpstorm-mcp/vulnerability-alerts -X PUT
gh api repos/TechSpokes/skill-ide-phpstorm-mcp/automated-security-fixes -X PUT
```

Create the default-branch ruleset with `gh api repos/TechSpokes/skill-ide-phpstorm-mcp/rulesets -X POST --input ruleset.json` using this JSON body:

```json
{
  "name": "main protection",
  "target": "branch",
  "enforcement": "active",
  "conditions": {
    "ref_name": {
      "include": [
        "~DEFAULT_BRANCH"
      ],
      "exclude": []
    }
  },
  "bypass_actors": [],
  "rules": [
    {
      "type": "pull_request",
      "parameters": {
        "required_approving_review_count": 0,
        "dismiss_stale_reviews_on_push": true,
        "require_code_owner_review": false,
        "require_last_push_approval": false,
        "required_review_thread_resolution": true,
        "allowed_merge_methods": [
          "squash"
        ]
      }
    },
    {
      "type": "required_status_checks",
      "parameters": {
        "strict_required_status_checks_policy": true,
        "required_status_checks": [
          {
            "context": "Validate skill package"
          }
        ]
      }
    },
    {
      "type": "non_fast_forward"
    },
    {
      "type": "deletion"
    },
    {
      "type": "required_linear_history"
    }
  ]
}
```

After any intentional reconfiguration, verify the configuration with:

```bash
gh api repos/TechSpokes/skill-ide-phpstorm-mcp
gh api repos/TechSpokes/skill-ide-phpstorm-mcp/rulesets
```

## Continuous Integration

`.github/workflows/ci.yml` runs on pull requests, pushes to `main`, and manual dispatch. It runs `npm run validate` and a packaging smoke test.

Use `v0.0.0` as the CI smoke-test tag. It is a placeholder and not a release version.

## Release Source

Use Git tags in `vX.Y.Z` format as the release source of truth.

## Required Files

Before tagging `vX.Y.Z`, ensure:

- `CHANGELOG.md` contains `## [vX.Y.Z]`.
- `docs/releases/vX.Y.Z.md` exists.
- `packaging/codex-plugin/.codex-plugin/plugin.json` uses version `X.Y.Z`.
- `packaging/claude-plugin/.claude-plugin/plugin.json` uses version `X.Y.Z`.

## Validation

Run:

```bash
npm run validate
```

Run a packaging smoke test:

```bash
npm run package -- v0.0.0
```

Before cutting a real release, run `npm run package -- vX.Y.Z` with the intended tag.

Expected assets:

- `dist/assets/phpstorm-mcp-vX.Y.Z.zip`
- `dist/assets/phpstorm-mcp-codex-plugin-vX.Y.Z.zip`
- `dist/assets/phpstorm-mcp-claude-plugin-vX.Y.Z.zip`

## Release Boundaries

Release assets must not include `.intake`, private research folders, `.template`, `.git`, `.idea`, `.github`, `docs`, `tmp`, `dist`, `node_modules`, or local environment files.

The packaged skill may include only runtime skill files from `src/` and plugin manifests from `packaging/`.
