# Lavertia

**Build Laravel interfaces in PHP, render with Inertia and React / Vue / Svelte.**

Lavertia is an experimental **component-driven** UI framework. Tables, form fields, actions, infolists and layout containers are composed as PHP objects without requiring a Resource for every screen. React, Vue and Svelte share the same server-side component protocol.

## Official repositories

| Repository | Responsibility | Status |
| --- | --- | --- |
| [lavertia/support](https://github.com/lavertia/support) | PHP component contracts and JSON protocol | v0.1 in [PR #4](https://github.com/lavertia/support/pull/4) |
| [lavertia/panels](https://github.com/lavertia/panels) | Inertia pages, panels, Starter Kit installer, initial renderers | v0.1 in [PR #4](https://github.com/lavertia/panels/pull/4) |
| [lavertia/ui](https://github.com/lavertia/ui) | Future independent frontend adapter distribution | Reserved / empty |
| [lavertia/forms](https://github.com/lavertia/forms) | Forms, fields and validation descriptors | Reserved / empty |
| [lavertia/tables](https://github.com/lavertia/tables) | Query-backed Tables, filtering and pagination | Reserved / empty |
| [lavertia/actions](https://github.com/lavertia/actions) | Actions, confirmation and modals | Reserved / empty |
| [lavertia/infolists](https://github.com/lavertia/infolists) | Structured read-only model display | Reserved / empty |
| [lavertia/lavertia-doc](https://github.com/lavertia/lavertia-doc) | Versioned documentation | Reserved / empty |
| **lavertia/lavertia** | Organization entrypoint and cross-package coordination | This repository |

**Each package has a single canonical source repository.** Do not copy `support` or `panels` into a new monorepo. The original prototype [PR #1](https://github.com/lavertia/lavertia/pull/1) has been superseded.

## Stack and integration

The current experimental target is PHP 8.3+, Laravel 12/13 and Inertia 3, using the official Laravel Starter Kits:

- **React 19 + TypeScript**
- **Vue 3 + TypeScript**
- **Svelte 5 + TypeScript**

The existing Starter Kit retains responsibility for authentication (Laravel Fortify/WorkOS where applicable), security middleware, session handling, application layouts and Vite. Lavertia adds PHP-defined component pages and the corresponding renderer.

Once `lavertia/support` and `lavertia/panels` are available via Composer (or configured local path repositories), install the frontend adapter into the selected Starter Kit:

```bash
composer require lavertia/panels:^0.1
php artisan lavertia:install --stack=vue
php artisan vendor:publish --tag=lavertia-config
```

Use `--stack=react` or `--stack=svelte` for the other official Inertia kits. This command deliberately refuses to overwrite existing files unless `--force` is supplied. Full installation and dev instructions: [Panels README](https://github.com/lavertia/panels/blob/feat/inertia-multistack-starterkits/README.md).

## Status and boundaries

**v0.1 is experimental, not production-ready.** Component composition, versioned JSON serialization and Vite compilation of each framework adapter are covered by current CI. Integration testing inside actual Starter Kits, secure server Actions, persisted Forms, Eloquent pagination/filtering, accessibility and SSR regression testing remain open.

Keep all authorization, validation, tenant scopes and executable PHP actions on the Laravel server. Only JSON-safe descriptors and explicitly selected data cross the Inertia boundary.

See [Laravel Starter Kits](https://laravel.com/starter-kits) and [Inertia](https://inertiajs.com/) for the upstream frameworks.
