# Research (Phase 0)

This document consolidates decisions, rationale, and alternatives to resolve all clarifications from the spec and to prepare for design.

## Decisions

1. Authentication: Use Laravel Sanctum for session + token auth.

    - Rationale: Simple, first-party, supports SPA/API tokens; good fit for monolith.
    - Alternatives: Passport (OAuth2) – heavier; JWT packages – external.

2. RBAC/Permissions: Use spatie/laravel-permission.

    - Rationale: Mature, widely used; role + permissions; integrates with policies and gates.
    - Alternatives: Custom gates/policies only – reimplements wheels.

3. Payments: Use Stripe with Stripe Connect (Standard accounts) and PaymentIntents for escrow.

    - Rationale: Standard onboarding smoother; platform fee via application_fee_amount; transfer to connected account on capture/release.
    - Alternatives: Custom accounts – more control, more compliance burden.

4. Escrow model: Authorize funds into platform balance, capture on approval to connected account minus platform fee; use separate Refunds on cancellations.

    - Rationale: Mirrors milestone flow with PaymentIntents and Transfers; idempotency keys for retries.
    - Alternatives: Separate Charges API – deprecated for Connect.

5. Queues: Use Redis + Horizon.

    - Rationale: Visibility and scaling; lightweight for initial launch.
    - Alternatives: Database queue – less scalable; SQS – external dependency early.

6. Notifications: Use Laravel Notifications (mail + database) and Mailhog/SMTP local.

    - Rationale: First-party, testable.

7. File storage: Local disk in dev; S3-compatible in prod; validation for size and types; virus scanning via clamav (queued) optional later.

8. API Documentation: Use Scribe to generate from routes/annotations.

    - Rationale: Fast to integrate; nice static docs.
    - Alternatives: L5-Swagger – heavier; manual OpenAPI – slower.

9. Search & discovery: Start with Eloquent queries + indexes; consider Scout + Meilisearch later if needed.

10. Localization & currency: Store amounts in ETB minor units (cents) as integers; present via helpers; use app timezone Africa/Addis_Ababa.

11. Rate limiting & moderation: Use Laravel throttle middleware; basic keyword filter service for messages; report/flag endpoints to admin queue.

12. Order state machine: Implement explicit enum and transitions validated in service; all transitions wrapped in DB transactions and outbox events for audit.

13. Testing strategy: Feature tests for main flows (order, payment, reviews); unit tests for services; webhook tests with fakes; factories for entities; coverage targets enforced.

## Open Questions Resolved

-   Student verification requirement: Not required at launch; optional badge later.
-   Auto-approval: 5 business days after delivery if client unresponsive.
-   Marketplace fees: 10% student, 5% client fee at checkout; implemented via application fee and separate client fee line item.

## Integration Patterns

-   Stripe Webhooks: Handle payment_intent.succeeded, payment_intent.payment_failed, charge.refunded, transfer.paid. Use signing secret and queue processing.
-   Idempotency: Provide idempotency keys on create/capture/refund; store keys per Order action.
-   Error handling: Consistent domain exceptions mapped to 4xx/5xx; log with context; no PII in logs.
