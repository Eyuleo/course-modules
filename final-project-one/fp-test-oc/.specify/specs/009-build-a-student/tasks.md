# Tasks: Student Skills Marketplace

**Input**: Design documents from `/specs/009-build-a-student/`

**Prerequisites**: plan.md, research.md, data-model.md, contracts/, quickstart.md

**Tests**: Not requested in spec, so optional - no test tasks generated.

**Organization**: Tasks grouped by user story for independent implementation.

## Format: `[ID] [P?] [Story] Description`
- **[P]**: Can run in parallel (different files)
- **[Story]**: User story (US1, US2...)

## Path Conventions
Laravel web app: app/, resources/views/, routes/, database/, etc.

## Phase 1: Setup (Shared Infrastructure)

**Purpose**: Project initialization

- [ ] T001 Install Laravel 11 project
- [ ] T002 [P] Configure MySQL database
- [ ] T003 [P] Install PNPM and Node dependencies
- [ ] T004 [P] Install PHP packages: laravel/breeze, spatie/laravel-permission, stripe/stripe-php, etc.
- [ ] T005 [P] Configure Tailwind CSS v4 with Vite
- [ ] T006 [P] Configure Stripe keys and webhook

---

## Phase 2: Foundational (Blocking Prerequisites)

**Purpose**: Core infrastructure

- [ ] T007 Create database migrations for User, Skill, Listing, Order, Payment, Review
- [ ] T008 [P] Setup authentication with Laravel Breeze
- [ ] T009 [P] Configure Spatie Laravel Permission for roles
- [ ] T010 [P] Create base models with relationships
- [ ] T011 [P] Setup API routes structure
- [ ] T012 [P] Create base Blade layouts and components
- [ ] T013 [P] Configure queues with Redis
- [ ] T014 [P] Setup notifications (email, in-app)

**Checkpoint**: Foundation ready

---

## Phase 3: User Story 1 - User Registration and Authentication (P1) 🎯 MVP

**Goal**: Users can register and login

**Independent Test**: Register a new user, login, access protected pages

### Implementation

- [ ] T015 [US1] Create User model with role enum
- [ ] T016 [US1] Run Breeze install for auth scaffolding
- [ ] T017 [US1] Customize registration form with role selection (buyer/seller)
- [ ] T018 [US1] Customize login form
- [ ] T019 [US1] Create dashboard view for users
- [ ] T020 [US1] Add role-based redirects after login

**Checkpoint**: US1 complete

---

## Phase 4: User Story 2 - Create Skill Listings (P1)

**Goal**: Sellers can create and manage listings

**Independent Test**: Login as seller, create listing, edit, view

### Implementation

- [ ] T021 [US2] Create Skill model and migration
- [ ] T022 [US2] Create Listing model and migration
- [ ] T023 [US2] Create ListingsController
- [ ] T024 [US2] Create routes for listings CRUD
- [ ] T025 [US2] Create Blade views for listing index, create, edit
- [ ] T026 [US2] Add form validation for listings
- [ ] T027 [US2] Implement listing status changes (draft/published)

**Checkpoint**: US2 complete

---

## Phase 5: User Story 3 - Browse and Search Listings (P1)

**Goal**: Buyers can browse and search listings

**Independent Test**: View listings page, search by skill/category

### Implementation

- [ ] T028 [US3] Create public listings index view
- [ ] T029 [US3] Add search functionality to listings
- [ ] T030 [US3] Add filtering by category
- [ ] T031 [US3] Create listing show view
- [ ] T032 [US3] Add pagination to listings

**Checkpoint**: US3 complete

---

## Phase 6: User Story 4 - Purchase Skills (P1)

**Goal**: Buyers can purchase listings

**Independent Test**: Select listing, create order, proceed to payment

### Implementation

- [ ] T033 [US4] Create Order model and migration
- [ ] T034 [US4] Create OrdersController
- [ ] T035 [US4] Add order creation from listing
- [ ] T036 [US4] Create order confirmation view
- [ ] T037 [US4] Add order status tracking

**Checkpoint**: US4 complete

---

## Phase 7: User Story 5 - Payment Processing (P1)

**Goal**: Secure payments with Stripe

**Independent Test**: Complete purchase with test payment

### Implementation

- [ ] T038 [US5] Install stripe-laravel package
- [ ] T039 [US5] Create Payment model
- [ ] T040 [US5] Create PaymentsController
- [ ] T041 [US5] Integrate Stripe payment intent creation
- [ ] T042 [US5] Add payment form with Stripe elements
- [ ] T043 [US5] Handle payment success/failure
- [ ] T044 [US5] Update order status on payment

**Checkpoint**: US5 complete

---

## Phase 8: User Story 6 - Payouts (P1)

**Goal**: Sellers receive payouts

**Independent Test**: After payment, payout to seller account

### Implementation

- [ ] T045 [US6] Setup Stripe Connect for sellers
- [ ] T046 [US6] Add stripe_account_id to User
- [ ] T047 [US6] Create onboarding flow for sellers
- [ ] T048 [US6] Implement payout on order completion
- [ ] T049 [US6] Handle webhook for payout events

**Checkpoint**: US6 complete

---

## Phase 9: User Story 7 - Reviews (P2)

**Goal**: Buyers can review purchases

**Independent Test**: After order, leave review

### Implementation

- [ ] T050 [US7] Create Review model
- [ ] T051 [US7] Create ReviewsController
- [ ] T052 [US7] Add review form after order
- [ ] T053 [US7] Display reviews on listing
- [ ] T054 [US7] Add rating system

**Checkpoint**: US7 complete

---

## Phase 10: User Story 8 - Messaging (P2)

**Goal**: Users can message each other

**Independent Test**: Send message to seller

### Implementation

- [ ] T055 [US8] Create Message model
- [ ] T056 [US8] Create MessagesController
- [ ] T057 [US8] Add messaging UI
- [ ] T058 [US8] Implement real-time messaging if needed

**Checkpoint**: US8 complete

---

## Phase 11: User Story 9 - Admin Management (P3)

**Goal**: Admins manage platform

**Independent Test**: Admin login, manage users/listings

### Implementation

- [ ] T059 [US9] Create admin role
- [ ] T060 [US9] Create admin dashboard
- [ ] T061 [US9] Add user management
- [ ] T062 [US9] Add listing moderation

**Checkpoint**: US9 complete

---

## Phase 12: Polish & Cross-Cutting Concerns

- [ ] T063 [P] Add responsive design with Tailwind
- [ ] T064 [P] Implement accessibility WCAG 2.1
- [ ] T065 [P] Add error handling and logging
- [ ] T066 [P] Optimize performance (caching, etc.)
- [ ] T067 [P] Add security measures
- [ ] T068 Run quickstart validation

---

## Dependencies & Execution Order

### Phase Dependencies

- Setup: No deps
- Foundational: After Setup
- User Stories: After Foundational, can be parallel
- Polish: After all desired stories

### User Story Dependencies

- US1: None
- US2: US1 (needs auth)
- US3: None
- US4: US3 (needs listings)
- US5: US4 (needs orders)
- US6: US5 (needs payments)
- US7: US4
- US8: US1
- US9: US1

### Parallel Opportunities

- Setup tasks [P]
- Foundational [P]
- User stories can be parallel if no deps
- Within story, [P] for different files

---

## Parallel Example: User Story 2

Task: Create Skill model and migration
Task: Create Listing model and migration

---

## Implementation Strategy

### MVP First (User Story 1 Only)

1. Complete Phase 1: Setup
2. Complete Phase 2: Foundational
3. Complete Phase 3: User Story 1
4. STOP and VALIDATE: Test US1 independently
5. Deploy/demo if ready

### Incremental Delivery

1. Complete Setup + Foundational → Foundation ready
2. Add US1 → Test independently → Deploy/Demo (MVP!)
3. Add US2 → Test independently → Deploy/Demo
4. Add US3 → Test independently → Deploy/Demo
5. Each story adds value without breaking previous stories

### Parallel Team Strategy

With multiple developers:

1. Team completes Setup + Foundational together
2. Once Foundational is done:
   - Developer A: US1 + US2
   - Developer B: US3 + US4
   - Developer C: US5 + US6
3. Stories complete and integrate independently

---

## Notes

- [P] tasks = different files, no dependencies
- [Story] label maps task to specific user story for traceability
- Each user story should be independently completable and testable
- Commit after each task or logical group
- Stop at any checkpoint to validate story independently
- Avoid: vague tasks, same file conflicts, cross-story dependencies that break independence