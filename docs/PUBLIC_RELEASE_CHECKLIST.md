# Lavertia public-source release checklist

**State:** public-source readiness is separate from version release readiness. The user/maintainer controls repository visibility; this document and its automation do **not** change it. Do not create `v0.x` tags until mandatory integration checks pass.

## 1. Security preflight — before changing visibility

- [ ] Merge a reviewed security-preflight PR in each repository (license, SECURITY.md, secret scan).
- [ ] Run the `Secret scanning (full Git history)` Actions workflow successfully in **each** repository. The workflow checks all Git history reachable from fetched branch and tag references and does not require a commercial Gitleaks Action license.
- [ ] Review any secret findings privately. **Revoke or rotate leaked credentials even if a later commit deleted them.** Do not copy secret values into issues, PR descriptions, logs or chats.
- [ ] Independently inspect GitHub Security alerts after publishing; GitHub automatically scans public repositories for supported secret types. Secret scanners cannot guarantee all unknown credentials are detected.
- [ ] Manually review binaries, images, committed fixtures, archives, private documents and third-party rights. Confirm no production/customer data.
- [ ] Explicitly decide whether historically committed personal author email addresses are acceptable. The old **panels** and **playground** commits contain a personal mailbox in Git commit metadata, and earlier **panels** license/Composer metadata also contained it. Correcting current files **does not scrub commit history**. History rewriting changes SHAs and can disrupt PRs; do it only as a separately approved migration with a backup and coordination.

## 2. Open-source governance

- [ ] Confirm each repository includes a correct MIT LICENSE file, SECURITY.md and an accurate README.
- [ ] Preserve upstream Laravel Starter Kit copyright/license notices and any third-party asset attributions. An MIT license for Lavertia-owned code does not supersede third-party licenses.
- [ ] Review organization membership, repository collaborators, deploy keys, Actions permissions, environment secrets, and branch workflows. Never echo secrets or copy tokens into documents.
- [ ] Avoid privileged `pull_request_target` jobs, automatic Dependabot merges, and unreviewed CI commits; keep the Dependabot PR update flow for reviewed changes.
- [ ] Configure a default read-only `GITHUB_TOKEN` and grant write scopes only to narrowly scoped, justified jobs.
- [ ] Enable GitHub's private vulnerability reporting, secret scanning alerts and push protection in repository security settings where available.

## 3. Protect default branches (after changing visibility)

- [ ] Go to **Settings → Rules → Rulesets** and create an active branch ruleset targeting `main` (if available for the account).
- [ ] Require pull requests, review approval, passed required status checks, and resolved conversations.
- [ ] Include `Gitleaks full-history audit` and the relevant PHP/runtime/frontend checks **after validating their exact check names and green runs**.
- [ ] Block branch deletion and force-push for `main`, limit bypass access, and review any automation with contents:write.
- [ ] Do not bypass a failed or skipped PHP integration job simply to merge a PR.

## 4. Cross-repository runtime verification

- [ ] `support`: PHPUnit on PHP 8.3 and 8.4 and protocol golden fixture.
- [ ] `forms` and `tables`: PHPUnit, style and dependency resolution with the real `support` package on PHP 8.3/8.4.
- [ ] `panels`: Composer/Testbench/PHP smoke, runtime TypeScript tests and production adapter builds on React/Vue/Svelte.
- [ ] `playground`: real Laravel 13 tests, Policies/Form Requests, Eloquent ownership, UI type checks and production builds on all three stacks.
- [ ] Refresh/check the three Composer lockfiles when canonical packages become merged; avoid hiding lock mismatches permanently using `--no-check-lock`.
- [ ] Run Composer/npm dependency advisory audits with compatible installed dependencies; triage material advisories.
- [ ] Merge the dependent PRs in dependency order, only with relevant tests successful. Do not assert that a skipped job passed.

## 5. Changing repository visibility

Recommended sequence: **support → forms → tables → panels → playground → lavertia**; docs is already Public. In each repository open **Settings → General → Danger Zone → Change repository visibility → Public**. Review GitHub's warning about public exposure of *all commits, branches, tags, releases and accessible artifacts* before confirming. Only repository administrators can perform this action and organization policy may restrict it.

There is no need to publish Packagist packages or create tags to make source viewable. Until stable versions exist, display an **Alpha / Work in Progress** notice.

## 6. Official tags and distribution (later)

- [ ] Publish Composer package tags for approved milestones, with semver alignment across dependencies.
- [ ] Verify source tags, Packagist metadata, license, changelogs and installation docs.
- [ ] Ensure `composer require` works in a clean external Laravel 12/13 application without unpublished path repositories.
- [ ] Announce what is explicitly tested and what remains experimental.

Release coordination: https://github.com/lavertia/lavertia/issues/3
