# Implementation Plan: Student Skills Marketplace (Ethiopia)

**Branch**: `005-build-a-student` | **Date**: 2025-10-13 | **Spec**: `/.specify/out/005-build-a-student/spec.md`
**Input**: Feature specification from `/.specify/out/005-build-a-student/spec.md`

## Summary

Build a two-sided marketplace enabling Clients to discover, hire, and pay Students for services with escrow protection. Backend uses Laravel 12 (PHP 8.2) with MySQL 8; queues (Redis) for async work; Stripe + Stripe Connect for payments and payouts; API-first with Sanctum auth; PNPM + Vite for frontend assets. Architecture: controllers → services → repositories; policies for RBAC; events/jobs for side effects; webhooks for Stripe. Focus on reliable order state machine, idempotent payments, and auditable transitions.

## Technical Context

-   Language/Version: PHP 8.2, Laravel 12
-   Primary Dependencies: laravel/framework, laravel/sanctum (API auth), spatie/laravel-permission (RBAC), stripe/stripe-php (payments + Connect), predis/predis or phpredis with Redis, laravel/horizon (queue dashboard), laravel/scout (optional search later), knuckleswtf/scribe (API docs)
-   Storage: MySQL 8 (utf8mb4), Redis (queues, cache), Filesystem local for dev (S3-ready)
-   Testing: PHPUnit 11 feature + unit tests; HTTP/DB tests with transactions; Stripe interactions faked
-   Target Platform: Linux container/VM, Laravel app served by PHP-FPM + Nginx; local via php artisan serve
-   Project Type: Web application (API + Blade)
-   Performance Goals: p95 TTFB ≤ 300ms on authenticated actions; ≤ 20 queries per request; no N+1 in hot paths
-   Constraints: Idempotent payment/order transitions; no external calls in tests; asset budget on critical pages ≤ 200KB gzipped
-   Scale/Scope: Initial launch ~1–5k users; design for growth (queues, caching, indexes)

## Constitution Check

Pre-design gate assessment:

-   Code Quality: Plan includes Pint, types/DTOs where needed, repository/service split; PASS (to be enforced in CI)
-   Testing: Coverage targets documented (≥80% overall, ≥90% payments/orders); tests planned across unit/feature/integration; PASS
-   UX Consistency: Shared Blade components and translations planned; A11y (WCAG 2.1 AA) noted; PASS
-   Performance: Budgets defined; N+1 avoidance and indexing planned; PASS

Post-design re-check:

-   Data model supports constraints and indexes; OK
-   OpenAPI covers P1 flows; OK, to be expanded in implementation
-   No unresolved clarifications; OK

## Project Structure

Documentation (this feature):

```
specs/005-build-a-student/
├── plan.md           # This file
├── research.md       # Phase 0
├── data-model.md     # Phase 1
├── quickstart.md     # Phase 1
└── contracts/
    └── openapi.yaml  # Phase 1
```

Source code (repository root) additions for this feature (planned):

```
app/
├── Models/            # StudentProfile, ServiceListing, Order, Payment, Review, MessageThread, Message, Category, Dispute, Attachment
├── Services/          # PaymentService, OrderService, ListingService, MessagingService, ReviewService
├── Repositories/      # ListingRepository, OrderRepository, PaymentRepository
├── Policies/          # ListingPolicy, OrderPolicy, MessagePolicy
├── Http/
│   ├── Controllers/   # API controllers per domain
│   └── Requests/      # FormRequest validators
└── Events/ & Listeners/ & Jobs/  # Domain events, async jobs

routes/
├── api.php            # Versioned API routes (v1)
└── web.php            # Web routes (marketing, dashboards)
```

Structure Decision: Single Laravel application (monolith) with layered modules by domain. API-first with Sanctum, Blade for initial views; can evolve to SPAs later.

## Complexity Tracking

None required at this time.

## Phase 0 → 2 Overview (what’s next)

-   Phase 0 (done in research.md): Resolve choices for auth, RBAC, payments (Connect), queues, API docs, and environment.
-   Phase 1 (this plan): Data model, API contracts (OpenAPI), quickstart bootstrap, agent context update.
-   Phase 2 (next command): Implementation tasks breakdown and delivery plan.
