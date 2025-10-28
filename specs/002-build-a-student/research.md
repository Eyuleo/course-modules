# Research: Student Skills Marketplace Platform

## Summary

Resolved open questions for architecture, tooling, and integrations to support a Laravel- and MySQL-based marketplace with secure payments via Stripe Connect, modern UX, and robust testing infrastructure.

## Decisions

### Frontend architecture
- **Decision**: Use Laravel + Inertia.js with Vue 3 and TypeScript for the authenticated app experience; expose public marketing/search pages as server-rendered Blade views enhanced with Vue components as needed.
- **Rationale**: Inertia keeps routing/server-rendering tied to Laravel while enabling SPA-like interactivity and shared validation. Vue 3 composition API, with TailwindCSS and Headless UI, provides approachable component patterns for the team.
- **Alternatives considered**:
  - **Livewire + Alpine**: simpler but less suited to complex real-time messaging dashboards and marketplace flows.
  - **Full SPA (Nuxt/Next)**: higher overhead, duplicate routing/auth layers.

### Search and discovery
- **Decision**: Adopt Laravel Scout with Meilisearch as the search backend for listings and profiles.
- **Rationale**: Meilisearch offers typo tolerance, geosearch road map, and self-hosted control over Ethiopian data locality. Scout integration is first-party, and Meilisearch has Laravel driver support.
- **Alternatives considered**:
  - **Algolia**: managed, faster to start but adds recurring cost and potential data residency concerns.
  - **Database LIKE queries**: insufficient for fuzzy skill matching and scaling.

### Browser/end-to-end testing
- **Decision**: Use Playwright (TypeScript) for cross-browser E2E verification, executed via PNPM scripts; complement with Laravel Pest + HTTP tests.
- **Rationale**: Playwright supports Chromium/Firefox/WebKit, integrates with CI artifacts, and matches PNPM-managed frontend stack.
- **Alternatives considered**:
  - **Laravel Dusk**: tightly coupled to PHP, limited to ChromeDriver, harder to parallelize at scale.
  - **Cypress**: excellent DX but single-browser (Chromium) and more licensing constraints for parallel runs.

### Stripe Connect implementation
- **Decision**: Use Laravel Cashier Stripe for core billing paired with Stripe Connect Custom accounts for students; manage Connect onboarding via Stripe Account Links API and capture payouts through scheduled jobs.
- **Rationale**: Cashier accelerates subscription/payment primitives while allowing custom Connect features. Custom accounts support local payouts; manual compliance steps handled via Stripe onboarding flows.
- **Alternatives considered**:
  - **Direct Stripe PHP SDK only**: more flexibility but increased boilerplate for invoices and webhooks.
  - **Stripe Standard accounts**: easier onboarding but less control over fees and escrow; does not fit marketplace escrow model.

### Real-time messaging and notifications
- **Decision**: Implement Laravel WebSockets (BeyondCode) with Redis-backed broadcasting; use Laravel Echo client on frontend for messaging updates, order status, and notifications.
- **Rationale**: Avoid Pusher SaaS costs, keep data local, reuse Laravel broadcasting drivers. Supports private channels and presence rooms required for order messaging.
- **Alternatives considered**:
  - **Pusher**: faster initial setup but recurring cost and regional data routing concerns.
  - **Server-Sent Events**: simpler but insufficient for bidirectional typing indicators/uploads.

### File storage for portfolios and deliverables
- **Decision**: Store user-uploaded files in Amazon S3-compatible object storage (e.g., AWS S3 or local MinIO in dev) with presigned upload URLs.
- **Rationale**: Handles 50 MB uploads reliably, integrates with Laravel Filesystem, and supports regional compliance. Presigned URLs reduce server load.
- **Alternatives considered**:
  - **Local disk storage**: unsuitable for scaling and horizontal deployments.
  - **Cloudinary**: good for images but not general deliverables.

### Queue and background processing
- **Decision**: Use Redis-backed Laravel queues with Horizon for monitoring.
- **Rationale**: Redis already required for websockets/cache; Horizon adds dashboards and retry control.
- **Alternatives considered**:
  - **Database queue**: simpler but risks contention.
  - **SQS**: powerful but adds AWS dependency.

### Analytics and instrumentation
- **Decision**: Instrument with Laravel Telescope in non-production, with production metrics via Horizon, Stripe dashboard, Meilisearch stats, and custom application metrics exported to Prometheus-compatible endpoint.
- **Rationale**: Provides debugging visibility while aligning with performance commitments.
- **Alternatives considered**:
  - **New Relic/Datadog**: optional future upgrade.

## Outstanding Questions

None; all identified NEEDS CLARIFICATION items resolved for planning.
