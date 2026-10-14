# Lavertia architecture (v0.1)

## Goal

Build Laravel screens with composable PHP components, independently of Resources or fixed page slots. Tables, infolists, actions, text inputs and layout containers all implement one base Component contract. Specialized contracts express capabilities without forcing inheritance from a Table/Page/Resource superclass.

## Data flow

1. Application PHP returns a tree of Component objects.
2. The support package validates and serializes the tree into JSON-safe props.
3. A Laravel page passes the tree to Inertia as a page prop.
4. The Vue renderer maps component types to visual components.
5. Local interactions are handled by Vue; persistence and authorization belong to Laravel endpoints.

A closure, Eloquent builder or PHP callable is **never** part of the serialized tree.

## Package boundaries

- packages/support: runtime-independent component contracts, value nodes, serializer, safety checks
- packages/panels: Laravel + Inertia page integration and initial Vue renderer
- docs / examples: integration notes and example screens

The code is a workspace; package release and external package distribution are not yet configured.

## Component semantics

- Immutable component builder: methods return cloned copies.
- Every node has a type, stable hierarchical key, a map of JSON-safe props and child components.
- Each sibling's key must be unique.
- A Table is just another Component; it can be nested in any compatible layout container.
- Table columns and Infolist entries are components, with specialized interfaces for their roles.
- Typed contracts are additive (TableComponent, FieldComponent, ActionComponent, etc.).
- Resources are optional future conveniences, not the universal root of the component tree.

## Execution and security boundary

- Server endpoints must enforce authentication, authorization (Laravel Policies), tenant scoping and validation.
- No arbitrary class/function identifiers are accepted from browser requests.
- Action v0.1 supports only safe navigation to relative paths or HTTPS links.
- The initial Table intentionally accepts only a bounded snapshot: at most 100 rows, scalar cells.
- Do not pass private model attributes to components without explicit select()/resource projections.

## Current limitations

- No server-side table sorting, filtering, pagination or row actions.
- No form persistence; TextInput currently represents browser-local state only.
- No server-side action dispatcher or authorization framework in Lavertia.
- No live/async loading or partial component hydration yet.
- Vue component integration has not yet been tested in a full Vite consumer application.
- This repository is experimental, not production-ready.

## Next milestone: v0.2

Build a component registry, query-backed tables with independent namespaced state, filter schemas, paginated endpoints with policy and tenant-scoping enforcement, server action identifiers and form submission/validation. Keep the query builder and authorization logic strictly on the server.
