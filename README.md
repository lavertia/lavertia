# Lavertia

**Define Laravel interfaces in PHP. Render through Inertia with React, Vue or Svelte.**

Lavertia is a PHP-first composable UI framework inspired by Flutter's Widget composition model and Filament's developer experience. Layouts, Tables, Forms, Actions and Infolists are described by PHP objects and serialized with **Component Protocol v1**. A Page can contain any combination of these components; a Filament-style Resource is not required.

> **Development preview (19 October 2026).** Source repository visibility is independent of production readiness. None of the v0.x packages is declared a stable production release.

## Packages and repositories

| Repository | Responsibility | Current state |
| --- | --- | --- |
| [support](https://github.com/lavertia/support) | PHP component contracts, immutable composition, safe JSON serialization | **Merged to main**; PHP 8.3/8.4 CI green |
| [panels](https://github.com/lavertia/panels) | Panel/Page routing, Laravel Modular page discovery, Inertia and React/Vue/Svelte adapters | v0.1/v0.2 implementation and [modular discovery #9](https://github.com/lavertia/panels/pull/9) plus [route precedence fix #10](https://github.com/lavertia/panels/pull/10) **merged**; CI green |
| [playground](https://github.com/lavertia/playground) | Real Laravel 13 React/Vue/Svelte applications | v0.2 [PR #9](https://github.com/lavertia/playground/pull/9) **merged**; three-stack Laravel/Pest, TypeScript, PostgreSQL and builds green. PHP auto-refresh [PR #11](https://github.com/lavertia/playground/pull/11) under review |
| [lavertia-doc](https://github.com/lavertia/lavertia-doc) | Documentation, guides, blog, plugin directory | Site merged to main and deployed through GitHub Pages |
| [forms](https://github.com/lavertia/forms) | Canonical form components | [PR #2](https://github.com/lavertia/forms/pull/2) **merged**; canonical descriptors available in source |
| [tables](https://github.com/lavertia/tables) | Canonical table engine | [PR #2](https://github.com/lavertia/tables/pull/2) **merged**; scoped pagination/filtering available in source |
| [actions](https://github.com/lavertia/actions) | Standalone action system (future extraction) | Reserved, not implemented |
| [infolists](https://github.com/lavertia/infolists) | Standalone Infolist engine (future extraction) | Reserved, not implemented |
| [ui](https://github.com/lavertia/ui) | Independent compiled frontend adapter packages | Reserved, not implemented |

Source code has one canonical repository per package. The abandoned monorepo prototype [PR #1](https://github.com/lavertia/lavertia/pull/1) is intentionally **not** the source of truth.

**Documentation:** https://lavertia.github.io/lavertia-doc/

## Security and public source release

All seven Lavertia source repositories are **public**. Follow [the public-release checklist](docs/PUBLIC_RELEASE_CHECKLIST.md) and [the security policy](SECURITY.md) for remaining maintainer controls, asset/privacy reviews and release gates. **Public source does not imply production-ready packages.** No stable version tag or public Packagist release has been approved.

## Framework targets

- PHP 8.3+ with Laravel 12 or Laravel 13 (currently verified against Laravel 13 Starter Kit source)
- Inertia.js 3
- React 19, Vue 3 and Svelte 5 frontend renderers
- Strict server-side authorization using Laravel Policies, scoped Eloquent builders and validation
- Protocol v1 with JSON-safe component trees, bounded size/depth and stable keys

```php
use Lavertia\Panels\Components\Form;
use Lavertia\Panels\Components\TextInput;
use Lavertia\Support\Components\Card;

Card::make([
    Form::make('profile')
        ->action('/account/profile')
        ->method('patch')
        ->components([
            TextInput::make('name')
                ->label('Name')
                ->required(),
        ]),
]);
```

A form action is **only** a server route. Lavertia does not bypass Laravel middleware, authorize models on your behalf or blindly persist fields.

## Laravel Modular integration

`lavertia/panels` discovers module-owned Pages from Composer PSR-4 packages, including `internachi/modular`, **without requiring Modular to be installed**. A module's Laravel service provider can register Pages for an existing, auth-protected Panel:

```php
public function boot(\Lavertia\Panels\PanelRegistry $panels): void
{
    $panels->discoverPages(
        panelId: 'admin',
        in: dirname(__DIR__).'/Lavertia/Pages',
        for: 'Modules\\Inventory\\Lavertia\\Pages',
    );
}
```

The same Inertia renderer displays module Pages in React, Vue or Svelte. The implementation preserves Panel middleware and route precedence even when module providers boot in different orders. Both ordinary and cached routes were verified using a **real Laravel 13 + InterNACHI/modular** installation ([CI proof](https://github.com/lavertia/panels/actions/runs/39191330039)). See the [integration guide](https://github.com/lavertia/panels/blob/main/docs/MODULAR_LARAVEL.md).

**Scope:** only module-owned Pages are implemented; Filament-style Resources, Widgets registration and navigation remain planned for v0.3. Vite browser refresh on PHP edits is tracked separately in [Playground PR #11](https://github.com/lavertia/playground/pull/11).

## Development milestone status

| Milestone | Implemented in code | Remaining before a stable release |
| --- | --- | --- |
| **0.1 - foundation** | Support protocol, Panel/Page registry, installer and three renderers **merged**, with Laravel runtime CI | Approved compatibility/installation policy, version tags and release signoff |
| **0.2 - Tables/Forms/i18n** | Canonical Forms/Tables, scoped Eloquent pagination, filters, locale/RTL and guarded form persistence **merged**; three-stack CI/SQLite/PostgreSQL green | Browser E2E, a11y, mobile/RTL manual QA, stable tag and compatibility signoff |
| **0.3 - Panels / modularity** | Composer-backed Laravel Modular **Page discovery** merged and verified against a real Laravel 13 module and route cache | Navigation registry, Panel auth and Resource/Relation Manager abstractions not implemented |
| **1.0 - stable** | Not released | Versioned backwards-compatibility, audited security, documented upgrade policy |

The current backend and adapter source uses temporary **Composer path repositories**. Do not expect a public `composer require lavertia/panels` installation to work until packages are tagged and published.

### Verify locally (all repositories public)

```bash
# Clone support, panels, forms, tables and playground as sibling directories.
cd playground/react
composer install
php artisan migrate --env=testing
php artisan test --filter=Lavertia
npm ci
npm run types:check
npm run build
```

Repeat for `vue` and `svelte`. The CI checkout and Composer path setup are described in each repository.

**Important QA gate:** cross-repository CI now checks out public packages with read-only GitHub credentials. It runs real Laravel/Pest tests plus frontend TypeScript/build checks; a successful lint/Vite build alone is not Laravel runtime compatibility evidence.

See the [installation guide](https://lavertia.github.io/lavertia-doc/start/installation/), [project status](https://lavertia.github.io/lavertia-doc/project/status/) and [roadmap](https://lavertia.github.io/lavertia-doc/project/roadmap/).

License: MIT for Lavertia-owned source (see [LICENSE.md](LICENSE.md)); upstream starter-kit and third-party assets retain their own licenses.
