# Tasks: Student Skills Marketplace (Ethiopia)

Feature branch: `005-build-a-student`  
Date: 2025-10-13

This document is auto-derived from the feature plan, data model, and OpenAPI contracts. It is organized by phases and user stories, with parallelization markers [P], explicit file paths, and execution order IDs (T001+).

Note on prerequisites step: Use `.specify/scripts/powershell/check-prerequisites.ps1 -Json` to resolve FEATURE_DIR and AVAILABLE_DOCS. FEATURE_DIR for this branch: `d:/Modules/final-project-one/fp-test-one/specs/005-build-a-student`.

## Phase 1: Setup (project initialization)

Goal: Prepare environment, dependencies, base configuration, and scaffolding required by all stories.

T001. Ensure local prerequisites installed [P] [X Completed]

-   Context: Windows host, bash shell. Verify tools exist: PHP 8.2+, Composer, Node 18+, PNPM. Skip PATH checks for MySQL and Redis per environment constraints.
-   Acceptance: Tools (PHP, Composer, Node, PNPM) report a version; `.env` exists. MySQL/Redis presence is not validated via PATH.
-   Files: `.env` (copy from `.env.example` if present), `config/app.php` (timezone if needed).
-   Notes: Set `APP_TIMEZONE=Africa/Addis_Ababa`, `CURRENCY=ETB`, and Stripe keys placeholders.

T002. Add Composer dependencies [P] [X Completed]

-   Run composer require (executed):
    -   `laravel/sanctum`, `spatie/laravel-permission`, `stripe/stripe-php`, `predis/predis`, `knuckleswtf/scribe`.
    -   Skipped `laravel/horizon` on Windows due to missing `ext-pcntl`/`ext-posix`. Revisit on Linux or use queues without Horizon locally.
-   Files: `composer.json`, `config/*` published by packages.
-   Note: Do not perform PATH checks for MySQL or Redis during this step.

T003. Configure Sanctum and API auth [X Completed]

-   Files: `routes/api.php` (created), `app/Models/User.php` (updated), `bootstrap/app.php` (routing).
-   Steps: Added `HasApiTokens` trait to `User`; registered API routes in `bootstrap/app.php`; created `routes/api.php` with a basic v1 group and health endpoint. Full guard/middleware wiring will follow when auth endpoints are implemented.

T004. Configure Roles & Permissions (Spatie) [X Completed]

-   Files: `config/permission.php` (published), migrations (published), `app/Models/User.php` (HasRoles added), `database/seeders/DatabaseSeeder.php` (seed roles/users conditional on tables).
-   Steps: Published Spatie Permission config & migrations; added `HasRoles` to `User`; seeder seeds `student`, `client`, `admin` roles and demo users when tables are present.

T005. Configure Horizon & Queues [P] [X Completed]

-   Files: `.env` updated (`QUEUE_CONNECTION=redis`, `REDIS_CLIENT=predis`), `config/queue.php` already supports redis.
-   Steps: Configured queues to use Redis via Predis. Deferred `laravel/horizon` on Windows due to `ext-pcntl`/`ext-posix`. Use `php artisan queue:work` locally.

T006. Base API structure & routing [P] [X Completed]

-   Files: `routes/api.php` (created and wired), `app/Http/Controllers/Api/BaseController.php` (helper), controller stubs for Auth, Listing, Order, Messaging, Review, StripeWebhook.
-   Steps: Versioned `v1` group added; all OpenAPI endpoints registered with 501 stubs; protected routes use `auth:sanctum` middleware.

T007. Error handling conventions [P] [X Completed]

-   Files: `app/Exceptions/Handler.php` (added JSON responses for API validation and HTTP exceptions), `app/Support/ApiResponse.php` (helper), base API controller uses JSON helpers.
-   Steps: Validation exceptions return 422 JSON under `api/*`; standardized success/error shapes for API.

T008. Frontend toolchain: Tailwind CSS + Vite + Alpine.js [P]

-   Goal: Install and configure Tailwind for Blade UI with Vite bundling and Alpine for lightweight interactivity.
-   Files: `package.json` (devDependencies), `tailwind.config.js`, `postcss.config.js`, `resources/css/app.css` (`@tailwind base; @tailwind components; @tailwind utilities;`), `resources/js/app.js` (import Alpine), `vite.config.js` (ensure Laravel plugin), `resources/views/layouts/app.blade.php` includes `@vite(['resources/css/app.css','resources/js/app.js'])`.
-   Notes: Prefer PNPM for installing packages; enable Tailwind content scan for `resources/views/**/*.blade.php`, `resources/js/**/*.js`.

T009. Base Blade layout and UI components [P]

-   Goal: Establish a consistent app shell and reusable components using Tailwind.
-   Files: `resources/views/layouts/app.blade.php` (container, header, footer), `resources/views/components/nav.blade.php`, `resources/views/components/button.blade.php`, `resources/views/components/input.blade.php`, `resources/views/components/textarea.blade.php`, `resources/views/components/select.blade.php`, `resources/views/components/flash.blade.php`, `resources/views/components/card.blade.php`.
-   Notes: Include responsive navbar with auth links, dark-mode-safe colors, and focus-visible styles for accessibility.

T010. Auth UI scaffolding (Blade, Tailwind) [P]

-   Goal: Provide login, register, password reset views that match Sanctum-backed auth.
-   Files: `routes/web.php` (auth routes), `resources/views/auth/{login,register,forgot-password,reset-password}.blade.php`, `app/Http/Controllers/Web/AuthController.php` (web forms if not using a package), `app/Http/Requests/Auth/{RegisterRequest,LoginRequest}.php` (shared or web-specific), `resources/views/components/form-errors.blade.php`.
-   Notes: If preferred, install Laravel Breeze (Blade) for rapid scaffolding and adapt to existing Sanctum setup; otherwise, implement minimal custom forms that post to web routes handled by controllers using the same service layer.

## Phase 2: Foundational (blocking prerequisites)

Goal: Database schema and core domain scaffolding that multiple stories depend on.

T011. Extend `users` table and model for roles and ratings [X Completed]

-   Files: `database/migrations/2025_10_14_000100_add_role_and_ratings_to_users_table.php` (new), `app/Models/User.php`.
-   Columns: `role` enum[`student`,`client`,`admin`], `rating_avg` float default 0, `rating_count` int default 0.
-   Notes: Keep compatibility with Spatie roles (role column is convenience mirror; Spatie remains source of truth). Add casts.

T012. Create `StudentProfile` entity [X Completed]

-   Files: migration `2025_10_14_000200_create_student_profiles_table.php`, model `app/Models/StudentProfile.php`.
-   Columns: `user_id` (unique FK), `skills` json, `bio` text, `education` json, `portfolio_url` nullable.
-   Indexes: `user_id` unique.

T013. Create `Category` and `ServiceListing` entities [X Completed]

-   Files: migrations `2025_10_14_000300_create_categories_table.php`, `2025_10_14_000400_create_service_listings_table.php`; models `app/Models/Category.php`, `app/Models/ServiceListing.php`.
-   Listing Columns: `student_user_id` FK, `category_id` FK nullable (if deferring categories), `title`, `description`, `price_cents` int, `currency` string default `ETB`, `delivery_days` int, `is_published` bool, `rating_avg` float, `rating_count` int.
-   Indexes: `(category_id)`, `(is_published)`, `(student_user_id)`, fulltext(`title`,`description`).

T014. Create `Order` and `Payment` entities [X Completed]

-   Files: migrations `2025_10_14_000500_create_orders_table.php`, `2025_10_14_000600_create_payments_table.php`; models `app/Models/Order.php`, `app/Models/Payment.php`.
-   Order Columns: `client_user_id`, `student_user_id`, `listing_id`, `scope` text, `requirements` json, `budget_cents` int, `currency`, `deadline_at` datetime, `state` enum[`draft`,`pending_funding`,`awaiting_acceptance`,`in_progress`,`in_review`,`completed`,`canceled`,`disputed`], `due_at` datetime nullable, `auto_approve_at` datetime nullable.
-   Payment Columns: `order_id`, `stripe_payment_intent_id` unique, `stripe_transfer_id` nullable, `amount_cents` int, `currency` string, `status` string, `last_error` json nullable, `captured_at` datetime nullable, `refunded_cents` int default 0.
-   Indexes per data-model.

T015. Create Messaging and Reviews entities [X Completed]

-   Files: migrations `2025_10_14_000700_create_message_threads_table.php`, `2025_10_14_000800_create_messages_table.php`, `2025_10_14_000900_create_reviews_table.php`; models `MessageThread`, `Message`, `Review`.
-   Thread Columns: `context_type` enum[`inquiry`,`order`], `context_id` bigint, `created_by_id`.
-   Message Columns: `thread_id`, `sender_id`, `body` text, `attachments` json, `flagged` bool.
-   Review Columns: `order_id`, `author_id`, `subject_user_id`, `rating` tinyint, `comment` text, timestamps.

T016. Seeders and factories for core entities [P] [X Completed]

-   Files: Added factories for StudentProfile, Category, ServiceListing, Order, Payment, MessageThread, Message, Review; updated `DatabaseSeeder` to seed roles, demo users, and a demo category/listing.

T017. Policies and Gates (listings, orders, messages) [X Completed]

-   Files: Added `app/Policies/ListingPolicy.php`, `OrderPolicy.php`, `MessagePolicy.php`, and `app/Providers/AuthServiceProvider.php` with policy mappings and a gate. Registered provider in `bootstrap/providers.php`.
-   Rules: students own listings; participants can view and transition orders; basic thread view gate.

T018. Service & Repository scaffolding [X Completed]

-   Files: `app/Services/{ListingService,OrderService,PaymentService,MessagingService,ReviewService}.php` created with minimal methods to support US1/US2 flows. Repositories can be added later if needed.

T019. API Controllers scaffolding [P] [X Completed]

-   Files: `app/Http/Controllers/Api/{AuthController,ListingController,OrderController,MessagingController,ReviewController,StripeWebhookController}.php`.
-   Actions: stubs matching OpenAPI paths, return `501` until implemented.

Checkpoint: After T019, migrations run cleanly; base models, services, controllers exist; routes compile.

## Phase 3 [Story US1, P1]: Auth + Listings (browse & create)

Story goal: As a student/client, I can register and log in; students can create listings; anyone can browse listings with filters.

Independent test criteria:

-   Can register with role student/client and receive token.
-   Can login and receive token.
-   GET `/v1/listings` supports q/category/min_price/max_price/delivery_days; returns paginated results.
-   Authenticated student can POST `/v1/listings` and see created record.

T020. Implement registration and login endpoints

-   Files: `app/Http/Controllers/Api/AuthController.php`, `routes/api.php`, `app/Http/Requests/Auth/{RegisterRequest,LoginRequest}.php`.
-   Details: Validate payload, create user, assign role, create token (Sanctum). Login with email/password, return token.

T021. Implement ListingRepository and ListingService

-   Files: `app/Repositories/ListingRepository.php`, `app/Services/ListingService.php`.
-   Methods: `search(filters)`, `createListing(student, data)`, apply fulltext where supported; enforce validation bounds.

T022. Implement listings browse (GET /listings)

-   Files: `app/Http/Controllers/Api/ListingController.php`.
-   Accept filters per OpenAPI; call service; return paginated JSON; ensure indexes used.

T023. Implement listing create (POST /listings)

-   Files: `app/Http/Controllers/Api/ListingController.php`, `app/Http/Requests/Listing/StoreListingRequest.php`, `app/Policies/ListingPolicy.php`.
-   Enforce student role; validate title/price/delivery_days; set `is_published=false` by default or as provided.

Parallelization example [US1]:

-   [P] T020 (AuthController + Requests) and T021 (Service/Repository) can proceed in parallel (different files).
-   [P] T022 and T023 can start after T021; they touch controller and requests, which are independent from T020.

Checkpoint US1: Endpoints return correct responses; tokens work; listings created and retrievable.

T024. Listings browse page (Blade) [US1]

-   Goal: Public listings index with search and filters using Tailwind.
-   Files: `routes/web.php` (GET `/listings`), `app/Http/Controllers/Web/ListingWebController.php` (`index`), `resources/views/listings/index.blade.php` (filter form + results), `resources/views/components/pills-filter.blade.php` (optional), `app/View/Components/Pagination.php` or vendor pagination override.
-   Details: Filters: q/category/min_price/max_price/delivery_days; server-rendered pagination; show rating and delivery time badges; reuse ListingService for queries.

T025. Listing create form (Blade) for students [US1]

-   Goal: Authenticated students can create a listing via form.
-   Files: `routes/web.php` (GET `/listings/create`, POST `/listings`), `app/Http/Controllers/Web/ListingWebController.php` (`create`,`store`), `resources/views/listings/create.blade.php`, `resources/views/components/form-section.blade.php`.
-   Details: Use `StoreListingRequest` for validation; enforce policy to restrict to students; show validation errors and flash success messages.

T026. Navigation and auth-aware header [US1] [P]

-   Goal: Header reflects login state; quick links to Listings, Create Listing (students), Orders, Messages, Profile.
-   Files: `resources/views/components/nav.blade.php`, `resources/views/layouts/app.blade.php` (include), `app/Providers/AppServiceProvider.php` (optional view composers for auth user/roles).
-   Notes: Add active link styles and mobile menu with Alpine.

## Phase 4 [Story US2, P1]: Orders core flow (create, fund, accept, deliver, approve)

Story goal: As a client, I can create an order for a listing, fund it (Stripe PaymentIntent), the student accepts, delivers, and the client approves to release funds.

Independent test criteria:

-   POST `/v1/orders` creates draft/pending_funding order referencing listing and parties.
-   POST `/v1/orders/{id}/fund` creates PaymentIntent and moves state to `pending_funding`; returns client secret.
-   POST `/v1/orders/{id}/accept` moves to `in_progress` if funded.
-   POST `/v1/orders/{id}/deliver` attaches deliverables and moves to `in_review`.
-   POST `/v1/orders/{id}/approve` captures/release to student and moves to `completed`.

T027. Implement OrderRepository and OrderService state machine

-   Files: `app/Repositories/OrderRepository.php`, `app/Services/OrderService.php`.
-   Include: enum of states, transition validation, DB transactions, timestamps (`auto_approve_at` calc), raise domain events.

T028. Implement PaymentService (Stripe)

-   Files: `app/Services/PaymentService.php`.
-   Methods: `createPaymentIntent(order, amount)`, `capture(order)`, `refund(order, amount?)`, store idempotency keys; handle ETB currency.

T029. Implement create order (POST /orders)

-   Files: `app/Http/Controllers/Api/OrderController.php`, `app/Http/Requests/Order/StoreOrderRequest.php`, `app/Policies/OrderPolicy.php`.
-   Validations: budget >= listing price; deadline future; set `pending_funding` or `awaiting_acceptance` based on flow.

T030. Implement fund escrow (POST /orders/{id}/fund)

-   Files: `app/Http/Controllers/Api/OrderController.php`.
-   Create PaymentIntent via PaymentService; persist Payment model; return client secret; keep state `pending_funding` until succeeded webhook.

T031. Implement accept, deliver, approve endpoints

-   Files: `app/Http/Controllers/Api/OrderController.php`.
-   Methods: `accept`, `deliver` (store deliverables path/notes), `approve` (capture and set completed); enforce policies for actor.

Parallelization example [US2]:

-   [P] T027 (OrderService) and T028 (PaymentService) can proceed in parallel.
-   [P] T029 can start once T027 exists; T030 depends on T028; T031 depends on both T027 and T028.

Checkpoint US2: Happy path from order creation to approval completes; PaymentIntent created and captured.

T032. Order create page (Blade) [US2]

-   Goal: Client initiates an order from a listing with scope, requirements, budget, and deadline.
-   Files: `routes/web.php` (GET `/orders/create` with `listing` param, POST `/orders`), `app/Http/Controllers/Web/OrderWebController.php` (`create`,`store`), `resources/views/orders/create.blade.php`.
-   Details: Pre-fill listing info; validate against listing min price; show delivery expectation.

T033. Order details page and timeline (Blade) [US2]

-   Goal: Display order state, participants, deliverables, and available actions per role.
-   Files: `routes/web.php` (GET `/orders/{order}`), `app/Http/Controllers/Web/OrderWebController.php` (`show`), `resources/views/orders/show.blade.php`, `resources/views/components/timeline.blade.php`, `resources/views/components/state-badge.blade.php`.
-   Details: Action buttons/forms: accept (student), deliver (student), approve (client) with confirmation modals.

T034. Fund order UI with Stripe Elements [US2]

-   Goal: Client funds order using Stripe Payment Element integrated with PaymentIntent client secret.
-   Files: `resources/js/stripe.js` (initialize Stripe/Elements), `resources/views/orders/partials/fund.blade.php` (mount Payment Element), `resources/views/orders/show.blade.php` (include partial), `resources/views/components/alert.blade.php` (status messages), `.env`/Vite env: `VITE_STRIPE_PUBLIC_KEY`.
-   Details: On successful confirmation, show pending message; rely on webhook to finalize; handle errors gracefully.

## Phase 5 [Story US3, P1]: Stripe webhook handling

Story goal: The system reacts to Stripe events to update payment/order records reliably.

Independent test criteria:

-   POST `/v1/stripe/webhook` accepts signed events and processes: `payment_intent.succeeded`, `payment_intent.payment_failed`, `charge.refunded`, `transfer.paid`.
-   Order state reflects payment success/failure; Payment model status updated.

T035. Implement StripeWebhookController and route

-   Files: `app/Http/Controllers/Api/StripeWebhookController.php`, `routes/api.php`.
-   Verify signature, dispatch jobs for processing, return 200 quickly.

T036. Implement webhook jobs/handlers

-   Files: `app/Jobs/Stripe/HandlePaymentIntentSucceeded.php`, `.../HandlePaymentIntentFailed.php`, `.../HandleChargeRefunded.php`, `.../HandleTransferPaid.php`.
-   Update Payment/Order, emit events/notifications, idempotent by event id record.

T037. Add webhook security and config [P]

-   Files: `.env` (`STRIPE_WEBHOOK_SECRET`), `config/services.php` (stripe), `app/Providers/AppServiceProvider.php` (bind Stripe client).
-   Ensure queue processing.

Checkpoint US3: Webhooks processed idempotently; orders/payments synchronized with Stripe.

T038. UI payment status banners and auto-refresh [US3] [P]

-   Goal: Reflect asynchronous payment status changes on order page after webhook processing.
-   Files: `resources/views/components/status-banner.blade.php`, `resources/views/orders/show.blade.php` (include banner), `resources/js/polling.js` (optional lightweight polling with Alpine setInterval), `routes/web.php` (AJAX endpoint to fetch order status JSON if polling enabled).
-   Details: Show success, pending, or failed states with Tailwind alerts; encourage manual refresh if JS disabled.

## Phase 6 [Story US4, P2]: Messaging (threads and messages)

Story goal: Participants can communicate on listing inquiries and order threads.

Independent test criteria:

-   GET `/v1/messages/threads/{context}/{id}` returns thread and messages for authorized users.
-   POST `/v1/messages/threads/{context}/{id}` creates a message for participants; applies simple moderation.

T039. Implement MessagingService and repository methods

-   Files: `app/Services/MessagingService.php`, `app/Repositories/MessageRepository.php`.
-   Methods: `getOrCreateThread(context)`, `listMessages(thread)`, `sendMessage(thread, user, body, attachments)`; moderation filter.

T040. Implement MessagingController endpoints

-   Files: `app/Http/Controllers/Api/MessagingController.php`, `app/Http/Requests/Message/SendMessageRequest.php`, policies.
-   Enforce participant access; throttle middleware.

T041. Notifications on new messages [P]

-   Files: `app/Notifications/NewMessageNotification.php`, mail templates, queue setup.
-   Notify the other party; use database + mail channels.

Checkpoint US4: Messaging works for authorized users; notifications delivered.

T042. Thread view and composer (Blade) [US4]

-   Goal: Show messages in a thread with sender avatar, timestamps, and attachments; provide a composer with moderation hints.
-   Files: `routes/web.php` (GET `/threads/{context}/{id}`), `app/Http/Controllers/Web/MessagingWebController.php` (`show`,`store`), `resources/views/messages/thread.blade.php`, `resources/views/components/message-item.blade.php`, `resources/views/components/message-composer.blade.php`.
-   Details: Scroll to latest; simple profanity filter feedback; throttle server-side.

T043. Lightweight live updates (polling) [US4] [P]

-   Goal: Periodically fetch new messages without full page reload.
-   Files: `resources/js/messages-poll.js`, `routes/web.php` (GET `/threads/{thread}/messages` JSON), `app/Http/Controllers/Web/MessagingWebController.php` (`messagesJson`).
-   Notes: Use Alpine with setInterval; disable when tab hidden.

## Phase 7 [Story US5, P2]: Reviews

Story goal: After completion, each party can leave one review about the other.

Independent test criteria:

-   POST `/v1/reviews` creates a review if order is `completed` and author is participant; enforces one-per-party.
-   User rating aggregates update.

T044. Implement ReviewService and repository

-   Files: `app/Services/ReviewService.php`, `app/Repositories/ReviewRepository.php`.
-   Methods: `createReview(order, author, rating, comment)`, update aggregates on `User` and `ServiceListing`.

T045. Implement ReviewController endpoint

-   Files: `app/Http/Controllers/Api/ReviewController.php`, `app/Http/Requests/Review/StoreReviewRequest.php`, policies.
-   Validations: rating 1–5, one-per-party-per-order.

Checkpoint US5: Reviews are persisted and aggregates updated.

T046. Review form UI (Blade) [US5]

-   Goal: Allow eligible party to submit a 1–5 star rating with comment after completion.
-   Files: `resources/views/reviews/create.blade.php` (or inline on order page), `resources/views/components/rating-stars.blade.php` (Alpine for interactive stars), `routes/web.php` (POST `/reviews`).
-   Details: Show validation errors; prevent duplicate submissions; show aggregates on listing and user profile cards.

## Phase 8 [Story US6, P2]: Order cancel and refunds

Story goal: Allow cancellations and refunds with proper state changes.

Independent test criteria:

-   POST `/v1/orders/{id}/cancel` transitions order to `canceled` with refund logic where applicable.
-   Payment refunded accordingly if funded and not captured.

T047. Implement cancel endpoint and service logic

-   Files: `app/Http/Controllers/Api/OrderController.php`, `app/Services/OrderService.php` (cancel), `app/Services/PaymentService.php` (refund).
-   Enforce actor permissions and time windows; partial refund support optional.

Checkpoint US6: Cancel and refund flows work consistently.

T048. Cancel/refund UI (Blade) [US6]

-   Goal: Provide cancel button with confirmation modal and refund info; guard by state and role.
-   Files: `resources/views/orders/partials/cancel-modal.blade.php`, `resources/views/components/modal.blade.php`, `resources/views/orders/show.blade.php` (include), `routes/web.php` (POST `/orders/{order}/cancel`).
-   Details: Explain refund timelines; disable when not applicable.

## Final Phase: Polish & Cross-Cutting Concerns

T049. API Docs with Scribe [P]

-   Files: `config/scribe.php`, annotations on controllers.
-   Generate static docs, publish to `public/docs` or similar.

T050. Indexes & N+1 audits [P]

-   Files: migrations to add indexes as per data model; `app/Models/*` with `with` eager loads; use Laravel Debugbar locally (dev-only).
-   Ensure p95 TTFB ≤ 300ms on hot paths; keep queries ≤ 20.

T051. Horizon dashboard protection & deployment

-   Files: `routes/web.php` (Horizon::auth), `config/horizon.php`.
-   Restrict to admin role; set queues and supervisors.

T052. Validation and error message consistency

-   Files: `app/Http/Requests/*`, `lang/en/validation.php`.
-   Ensure consistent messages and formats across endpoints.

T053. Logging & observability [P]

-   Files: `config/logging.php`, structured context in service exceptions, mask PII; add basic audit logs for state transitions.

T054. Blade component library consolidation [P]

-   Files: `resources/views/components/*` grouped and documented; remove duplicates; add README for components.
-   Notes: Ensure components cover buttons, inputs, selects, textareas, alerts, badges, modals, cards, pagination.

T055. Flash/toast notifications [P]

-   Files: `resources/views/components/flash.blade.php` (session-based), `resources/js/toast.js` (optional), include in base layout.
-   Details: Auto-dismiss with Alpine; accessible role=alert; variants: success, error, info.

T056. Tailwind pagination and vendor overrides [P]

-   Files: `resources/views/vendor/pagination/tailwind.blade.php` (publish/customize), global styles for active/hover states.
-   Notes: Ensure consistent pagination across listings and messages.

T057. Error pages (Blade) [P]

-   Files: `resources/views/errors/404.blade.php`, `resources/views/errors/500.blade.php` with Tailwind styling; optional `419`, `429`.
-   Notes: Include link back to home/listings.

T058. Accessibility and color contrast audit [P]

-   Files: N/A (adjust styles/components as needed); document fixes in `README.md` section.
-   Details: Verify focus states, labels, aria attributes, and sufficient contrast; keyboard navigability across forms.

---

## Dependencies (story completion order)

1. Phase 1: Setup → 2. Foundational → 3. US1 (Auth + Listings, P1) → 4. US2 (Orders core, P1) → 5. US3 (Stripe webhooks, P1) → 6. US4 (Messaging, P2) → 7. US5 (Reviews, P2) → 8. US6 (Cancel/Refunds, P2) → Final Polish.

Graph (simplified):

-   Setup → Foundational → US1 → US2 → US3 → {US4, US5, US6 in any order after US3} → Polish

UI considerations:

-   Frontend Setup (T008–T010) ideally completes during Setup, but can proceed in parallel with backend Foundational tasks.
-   Each story's UI tasks (e.g., T024–T026 for US1) depend on core services/endpoints for data but can be scaffolded with placeholders first.

## Parallel execution examples (per story)

-   US1: [P] Auth endpoints (T020) // Listing service (T021). After T021: [P] browse (T022) // create (T023).
-   US1 (UI): [P] Tailwind/layout (T008–T009) // Auth UI (T010). After T021: [P] Listings browse page (T024) // Listing create form (T025) // Nav (T026).
-   US2: [P] OrderService (T027) // PaymentService (T028). Then [P] create order (T029) // fund (T030). Approvals (T031) last.
-   US2 (UI): [P] Order create page (T032) // Order details/timeline (T033). Fund UI (T034) after T030 exposes client secret.
-   US3: [P] Webhook controller (T035) // Jobs (T036) // Config (T037).
-   US3 (UI): [P] Status banners and optional polling (T038).
-   US4: [P] Messaging service (T039) // Controller + requests (T040) // Notifications (T041).
-   US4 (UI): [P] Thread view/composer (T042) // Polling (T043).
-   US5: [P] Review service (T044) // Controller (T045).
-   US5 (UI): [P] Review form and rating stars (T046).
-   US6: Cancel logic (T047) depends on US2 + US3.
-   US6 (UI): Cancel/refund modal (T048) depends on T047.

## Implementation strategy

-   MVP scope: Complete US1 + US2 + US3 only. This delivers the core transactional flow (auth → listings → orders → funding → accept → deliver → approve) with Stripe synchronization. Messaging, reviews, and cancellations are Phase 2.
-   Layered approach: Controllers → Services → Repositories; encapsulate Stripe logic in PaymentService; validate state transitions in OrderService; policies enforce access control.
-   Idempotency & reliability: All payment operations use idempotency keys; webhook processing is queued and idempotent by event id.

UI approach:

-   Server-rendered Blade templates styled with Tailwind; minimal Alpine.js for interactivity (menus, modals, toasts, polling).
-   Use shared components to standardize forms and actions; prefer progressive enhancement (works without JS).
-   Stripe Elements only where needed (funding flow); avoid heavy frontend frameworks.

---

## Report

Output path: `d:/Modules/final-project-one/fp-test-one/specs/005-build-a-student/tasks.md`

Totals:

-   Total tasks: 58
-   Per story/phase:
    -   Setup: 10 (T001–T010)
    -   Foundational: 9 (T011–T019)
    -   US1 (P1): 7 (T020–T026)
    -   US2 (P1): 8 (T027–T034)
    -   US3 (P1): 4 (T035–T038)
    -   US4 (P2): 5 (T039–T043)
    -   US5 (P2): 3 (T044–T046)
    -   US6 (P2): 2 (T047–T048)
    -   Polish: 10 (T049–T058)

Parallel opportunities identified:

-   Significant within US1, US2, US3, US4, UI setup, and Polish tasks as marked [P].

Independent test criteria:

-   Provided per story to enable incremental verification.

Suggested MVP scope:

-   Complete US1 + US2 + US3.
