# Development quickstart

## Workspace setup

Requires PHP 8.3+ and Composer 2:

```bash
git clone https://github.com/fnx-software/lavertia.git
cd lavertia
composer install
composer test
```

The root Composer workspace uses local path repositories for packages/support and packages/panels. The workspace is private and is not yet a published installable package.

## Using the packages in a Laravel + Inertia app

Use a Laravel 12 or Laravel 13 application with Inertia.js 3, Vue 3 and a working Vite/Tailwind setup. Add path repositories for development (adjust the path):

```json
{
  "repositories": [
    {
      "type": "path",
      "url": "../lavertia/packages/*",
      "options": {
        "symlink": true,
        "versions": {
          "lavertia/support": "0.1.0",
          "lavertia/panels": "0.1.0"
        }
      }
    }
  ]
}
```

Run:

```bash
composer require lavertia/panels:^0.1
npm install vue @inertiajs/vue3
php artisan vendor:publish --tag=lavertia-vue
```

Inertia's page resolver must resolve `resources/js/Pages/Lavertia/PanelPage.vue`. For example, in an existing Vue Inertia boot file:

```ts
resolve: (name) => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true });
    return pages[`./Pages/${name}.vue`];
},
```

Then configure a route to an invokable Page subclass. See examples/OrganizationPage.php.

This is **not** a complete installation script: the consuming app must also have Inertia middleware, its root Blade view, a Vue/Vite build, Tailwind CSS, session/CSRF middleware and authentication configured.

## Design notes

- PHP components describe the view; Vue does not execute arbitrary PHP methods.
- `Table::rows()` is intentionally bounded. Pagination and filters come in a later release.
- All user-facing data must pass through application policies and tenant scoping.
- Use app-defined route names and endpoint authorization; there is no automatic secure CRUD layer yet.
