# Feature Specification: Student Skills Marketplace (Ethiopia)

**Feature Branch**: `005-build-a-student`  
**Created**: 2025-10-13  
**Status**: Draft  
**Input**: User description: "Build a Student Skills Marketplace platform designed to connect university students in Ethiopia with clients who need their services. The platform should allow students to showcase their skills, create service listings, and earn income by completing client assignments. Clients need to easily discover, evaluate, and hire student providers with confidence.

The core objective is to automate and centralize the service discovery, ordering, communication, and payment process for both students and clients, replacing the current fragmented and insecure informal methods. Key features should include user registration for both students and clients, service listing creation with categorization and portfolio samples, secure order placement and management, integrated in-platform messaging, secure payment handling with escrow for job protection, and a review/rating system to build credibility and trust in the marketplace.

This marketplace seeks to empower students by enabling them to monetize their abilities safely, providing a steady income source during their academic careers, while simultaneously offering clients affordable and verified services. The platform should aim to reduce inefficiencies, payment risks, and missed opportunities, and support entrepreneurship and economic growth within the student community.  
Students doesn't need to verify their student status."

## User Scenarios & Testing _(mandatory)_

### User Story 1 - Client discovers, evaluates, and hires (Priority: P1)

A client searches or browses categories to discover student service listings, evaluates profiles and reviews, selects a listing, submits an order with a clear brief and budget, and funds escrow to start the job.

**Why this priority**: This flow drives revenue and trust: clients must be able to reliably hire with protection for both sides.

**Independent Test**: Can a new client complete a hire from discovery to escrow funding without any student-side action beyond acceptance? Value: a paid order initiated.

**Acceptance Scenarios**:

1. Given a new client account, when they search for "Graphic Design" and open a listing, then they can view profile, portfolio, price, delivery time, and rating.
2. Given a chosen listing, when the client clicks "Order", fills scope, deadline, and budget, and confirms, then an order is created in Pending Acceptance and escrow funding is requested.
3. Given the order in Pending Funding, when the client funds escrow successfully, then the order state moves to Awaiting Student Acceptance and student is notified.

---

### User Story 2 - Student accepts order and delivers (Priority: P1)

A student receives a new order request, reviews scope and budget, accepts or declines, communicates with the client, delivers files/links, and requests release of escrow upon completion.

**Why this priority**: Enables earning and service fulfillment for students.

**Independent Test**: Given an existing funded order, the student can accept and complete delivery with messaging and submit for approval.

**Acceptance Scenarios**:

1. Given a funded order awaiting acceptance, when the student accepts within the allowed window, then the order state becomes In Progress and a delivery due date is set.
2. Given an In Progress order, when the student uploads deliverables and clicks "Submit for Review", then the order state becomes In Review and the client is notified.
3. Given an In Review order, when the client approves, then escrow is released to the student and the order is marked Completed.

---

### User Story 3 - Reviews and ratings (Priority: P2)

After order completion, both parties can leave a review and a star rating to build credibility and inform future clients.

**Why this priority**: Builds trust and marketplace health; increases conversion.

**Independent Test**: After completion, each party can submit one review within a window; average rating updates on listings.

**Acceptance Scenarios**:

1. Given a Completed order, when the client submits a rating and comment within 14 days, then the review appears on the student’s profile and listing.
2. Given a Completed order, when the student reviews the client, then the review appears on the client profile; no changes to listing ratings.

---

### User Story 4 - Service listing and portfolio creation (Priority: P2)

A student creates or edits a service listing with title, description, category, pricing, delivery time, and portfolio samples.

**Why this priority**: Supply-side content enables discovery and orders.

**Independent Test**: A student can publish a compliant listing that appears in search and category pages.

**Acceptance Scenarios**:

1. Given a student account, when they create a listing with required fields and at least one portfolio sample, then the listing is published and becomes discoverable.
2. Given an existing listing, when the student edits price or delivery time, then changes are saved and reflected in new orders without affecting active orders.

---

### User Story 5 - In-platform messaging (Priority: P2)

Clients and students exchange messages and attachments within the order or pre-order inquiry to clarify requirements.

**Why this priority**: Reduces scope creep and miscommunication while keeping records.

**Independent Test**: Parties can send/receive messages on a thread with delivery status and basic moderation.

**Acceptance Scenarios**:

1. Given an order, when either party sends a message, then the other party receives a notification and can view it in the order thread.
2. Given a pre-order inquiry, when the student responds, then the client can convert the inquiry into an order with the agreed details.

---

### User Story 6 - Order changes and cancellations (Priority: P3)

Parties can request scope changes, deadline extensions, or cancel orders under defined rules.

**Why this priority**: Handles real-world deviations and reduces disputes.

**Independent Test**: Change requests and cancellations follow structured approval and refund logic.

**Acceptance Scenarios**:

1. Given an In Progress order, when the client requests a deadline extension and the student accepts, then the due date updates and both parties are notified.
2. Given an In Progress order, when the client cancels due to no response within the response window, then escrow is refunded per policy and the order closes.

### Edge Cases

-   What happens when escrow funding fails? Payment is declined; order remains Pending Funding; client is prompted to retry or change method.
-   How does system handle a no-response student? If student does not accept within the response window, order auto-cancels and escrow (if funded) is refunded.
-   What if deliverables are too large to upload? Support large-file alternatives via link attachments; warn on size limits and provide guidance.
-   What if a client disputes the quality? A dispute workflow pauses the order, restricts further changes, and offers resolution options (assumed initial policy: 7-day negotiation window followed by platform resolution within 5 business days; refunds based on order stage).
-   What if a client requests off-platform payment? Messaging flags and warns; links masked; repeated attempts may restrict account.

## Requirements _(mandatory)_

### Functional Requirements

-   FR-001: System MUST allow users to register as Student or Client and log in.
-   FR-002: System MUST allow Students to create and manage profiles including skills, bio, education, and portfolio links/samples.
-   FR-003: System MUST enable Students to create, edit, publish, and unpublish service listings with category, title, description, price, and delivery time.
-   FR-004: System MUST provide Clients with search, category browsing, and filters (category, price range, delivery time, rating, keywords) to discover listings.
-   FR-005: System MUST allow Clients to create an order from a listing, including scope, requirements, attachments, budget, and deadline.
-   FR-006: System MUST support escrow funding by Clients before work begins; orders cannot start until funded. Payments and escrow will use Stripe with Stripe Connect; supported methods include cards and any locally available methods via Stripe.
-   FR-007: System MUST notify Students of new orders and allow accept/decline within a defined response window (e.g., 48 hours).
-   FR-008: System MUST support in-platform messaging for pre-order inquiries and order threads with text and attachments; maintain an auditable history.
-   FR-009: System MUST track order states: Draft, Pending Funding, Awaiting Acceptance, In Progress, In Review, Completed, Canceled, Disputed.
-   FR-010: System MUST allow Students to submit deliverables and request approval; Clients approve or request changes.
-   FR-011: System MUST release escrow to Student upon Client approval or per auto-approval timeout of 5 business days if the client is unresponsive after delivery; refunds after release follow standard dispute resolution and refund policy.
-   FR-012: System MUST support order changes: client-student mutual agreement for scope or deadlines; record and notify both parties.
-   FR-013: System MUST enable cancellations per policy with appropriate partial or full refunds based on order stage and activity.
-   FR-014: System MUST provide a review and rating system for both parties after completion; one review per party per order; a review window (e.g., 14 days).
-   FR-015: System MUST provide basic moderation: flag/report users, filter prohibited content in messaging, and admin review tools.
-   FR-016: System MUST provide notifications (in-app and email) for key events: new orders, messages, deadlines approaching, submissions, approvals, and reviews.
-   FR-017: System MUST provide order and earnings dashboards for Students; orders and spend history for Clients.
-   FR-018: System MUST provide identity basics: no student verification required per input; optional phone/email verification to protect accounts.
-   FR-019: System MUST provide localized content where applicable (currency display in ETB, local time zone display, date formats).
-   FR-020: System MUST provide terms/policies: cancellation policy, dispute policy summary, and marketplace fee disclosure. Marketplace fee: 10% charged to the student and 5% service fee charged to the client at checkout.

### Non-Functional Requirements

-   NFR-UX-001: Interfaces MUST use shared components and meet WCAG 2.1 AA for this feature.
-   NFR-PERF-001: p95 time-to-first-interaction for listing browse and order create ≤ 1.5s under typical local connectivity; no N+1 queries evident in primary flows.
-   NFR-TEST-001: Maintain ≥ 80% coverage overall (≥ 90% for order, payment, and review flows) with deterministic tests.
-   NFR-RELIABILITY-001: Payment and order state transitions MUST be idempotent; no duplicate charges or double state transitions on retry.
-   NFR-SEC-001: Sensitive data at rest and in transit MUST be protected; attachments scanned for malware; rate limits on messaging to reduce spam.
-   NFR-PRIVACY-001: Only necessary personal data collected; clear retention and deletion controls; users can export their data upon request.
-   NFR-OBS-001: Key business events (order created, funded, accepted, delivered, approved, refunded) MUST be auditable.

### Key Entities

-   User: Represents a Student or Client; attributes include role, name, contact, ratings summary.
-   Profile (Student): Skills, bio, education, portfolio references.
-   ServiceListing: Student offering with category, title, description, price, delivery time, samples.
-   PortfolioItem: Media or links demonstrating past work; associated with Student and optionally a Listing.
-   Order: Contract between Client and Student; includes listing reference, scope, budget, deadlines, state, timestamps.
-   Escrow/Payment: Records funding, releases, refunds, and fees linked to Orders.
-   MessageThread/Message: Communications tied to a listing inquiry or order; supports attachments and moderation flags.
-   Review: Post-completion rating and feedback from each party.
-   Category: Taxonomy for discovery and filters.
-   Dispute: Captures disputes, reasons, evidence, and resolution outcome; pauses order progression.

## Success Criteria (mandatory)

### Measurable Outcomes

-   SC-001: At least 70% of first-time clients can discover and initiate an order in under 5 minutes from landing on the marketplace.
-   SC-002: 90% of In Progress orders complete without dispute; dispute rate ≤ 10% of funded orders in first release.
-   SC-003: 95% of listing browse and search interactions feel instant to users (perceived response ≤ 1 second on typical local connectivity).
-   SC-004: 80% of completed orders receive at least one review within 14 days of completion.
-   SC-005: 85% of escrow-funded orders release payment within 3 days of submission approval or auto-approval.
-   SC-006: Students report ≥ 80% satisfaction with clarity of order requirements (post-order survey) in the first 3 months.

### Quality Gates

-   QG-QUALITY: Pint clean, static analysis clean for changed areas, no dead code.
-   QG-UX: Accessibility checklist completed, screenshots attached, consistent messaging via translations.
-   QG-PERF: Budgets reviewed; added benchmarks or reasoning in plan.

## Assumptions

-   Students are not required to verify student status (per input); optional verification may be added later for badges.
-   Currency presented primarily in ETB; international clients may view converted amounts for reference.
-   Baseline response window for student acceptance is 48 hours unless configured.
-   Auto-approval after student submission occurs after 5 business days if the client is unresponsive.
-   Marketplace fee is disclosed at order creation: 10% from student earnings and 5% client service fee.
-   Payments and escrow will use Stripe with Stripe Connect (cards and supported local methods via Stripe).

## Open Questions

None at this time.
