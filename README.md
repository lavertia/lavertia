# Lavertia

**PHP-first, component-driven UI framework for Laravel + Inertia.js.**

Lavertia treats tables, form fields, infolists, actions, and layout containers as composable components. A table can live inside a card, a tab, or a page without requiring a Resource.

> Status: experimental foundation (v0.1). Not production-ready.

## Architecture

- `packages/support`: component contracts, immutable composition, JSON serialization.
- `packages/panels`: Inertia page adapter, component definitions, Vue renderer.
- `docs/`: implementation notes and examples.

### Core rules

1. Components compose through explicit contracts; Resources are optional.
2. PHP owns authorization, validation, queries and server actions.
3. Vue owns local UI state and client-side interactions.
4. Serialize only JSON-safe data; never send PHP closures to the browser.
5. Tables are independent components; server-driven pagination and filters will follow.

Development is tracked on feature branches and reviewed through pull requests.
