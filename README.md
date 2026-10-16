# Lavertia

**Define Laravel interfaces in PHP. Render through Inertia with React, Vue or Svelte.**

Lavertia is a PHP-first composable UI framework inspired by Flutter's Widget composition model and Filament's developer experience. Layouts, Tables, Forms, Actions and Infolists are described by PHP objects and serialized with **Component Protocol v1**. A Page can contain any combination of these components; a Filament-style Resource is not required.

> **Development preview (16 October 2026).** Source repository visibility is independent of production readiness. None of the v0.x packages is declared a stable production release.

## Packages and repositories

| Repository | Responsibility | Current state |
| --- | --- | --- |
| [support](https://github.com/lavertia/support) | PHP component contracts, immutable composition, safe JSON serialization | **Merged to main**; PHP 8.3/8.4 CI green |
| [panels](https://github.com/lavertia/panels) | Laravel Panel/Page registry, Inertia, Starter Kit installers, three frontend adapters | v0.1 [PR #4](https://github.com/lavertia/panels/pull/4) and dependent v0.2 [PR #5](https://github.com/lavertia/panels/pull/5)/[PR #6](https://github.com/lavertia/panels/pull/6) still draft |
| [playground](https://github.com/lavertia/playground) | Real Laravel 13 React/Vue/Svelte applications | v0.2 [PR #2](https://github.com/lavertia/playground/pull/2) draft; Laravel integration CI currently gated |
| [lavertia-doc](https://github.com/lavertia/lavertia-doc) | Documentation, guides, blog, plugin directory | Site merged to main and deployed through GitHub Pages |
| [forms](https://github.com/lavertia/forms) | Canonical form components | [PR #2](https://github.com/lavertia/forms/pull/2) drafted; tests and merge pending |
| [tables](https://github.com/lavertia/tables) | Canonical table engine | [PR #2](https://github.com/lavertia/tables/pull/2) drafted; tests and merge pending |
| [actions](https://github.com/lavertia/actions) | Standalone action system (future extraction) | Reserved, not implemented |
| [infolists](https://github.com/lavertia/infolists) | Standalone Infolist engine (future extraction) | Reserved, not implemented |
| [ui](https://github.com/lavertia/ui) | Independent compiled frontend adapter packages | Reserved, not implemented |

Source code has one canonical repository per package. The abandoned monorepo prototype [PR #1](https://github.com/lavertia/lavertia/pull/1) is intentionally **not** the source of truth.

**Documentation:** https://lavertia.github.io/lavertia-doc/

## Security and public source release

Before changing a repository to Public, follow [the public-release checklist](docs/PUBLIC_RELEASE_CHECKLIST.md) and review [the security policy](SECURITY.md). The pre-release branches and pull requests are not production-ready, even after their source is visible. Do not create version tags until every required runtime integration check has passed.

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

## Development milestone status

| Milestone | Implemented in code | Remaining before a stable release |
| --- | --- | --- |
| **0.1 - foundation** | Support protocol, Panel/Page registry, installer, three Inertia renderer builds | Panels merge, real Laravel integration tests, Composer version tags, compatibility contract |
| **0.2 - Tables/Forms/i18n** | Scoped Eloquent pagination, filters/column controls, locale/RTL, Inertia form POST/PUT/PATCH, user-owned persistence demo | Cross-stack integration, browser QA, canonical Forms/Tables package merges and release gating |
| **0.3 - optional Panels product** | Design plan only | Navigation registry, dedicated Panel auth and Resources/Relation Managers |
| **1.0 - stable** | Not released | Versioned backwards-compatibility, audited security, documented upgrade policy |

The current backend and adapter source uses temporary **Composer path repositories**. Do not expect a public `composer require lavertia/panels` installation to work until packages are tagged and published.

### Verify locally (authorized repository access required)

```bash
# Clone support, panels and playground side by side.
cd playground/react
composer install
php artisan migrate --env=testing
php artisan test --filter=Lavertia
npm ci
npm run types:check
npm run build
```

Repeat for `vue` and `svelte`. The CI checkout and Composer path setup are described in each repository.

**Important QA gate:** cross-repository CI needs a read-only `LAVERTIA_READ_TOKEN` only while required dependency repositories are private. Public repos can be checked out with the default GitHub token. A successful static lint/Vite build is not evidence of Laravel runtime compatibility.

See the [installation guide](https://lavertia.github.io/lavertia-doc/start/installation/), [project status](https://lavertia.github.io/lavertia-doc/project/status/) and [roadmap](https://lavertia.github.io/lavertia-doc/project/roadmap/).

License: MIT for Lavertia-owned source (see [LICENSE.md](LICENSE.md)); upstream starter-kit and third-party assets retain their own licenses.
