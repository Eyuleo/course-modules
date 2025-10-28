# Feature Specification: Student Skills Marketplace Platform

**Feature Branch**: `[002-build-a-student]`  
**Created**: 2025-10-13  
**Status**: Draft  
**Input**: User description: "Build a Student Skills Marketplace platform designed to connect university students in Ethiopia with clients who need their services. The platform should allow students to showcase their skills, create service listings, and earn income by completing client assignments. Clients need to easily discover, evaluate, and hire student providers with confidence.

The core objective is to automate and centralize the service discovery, ordering, communication, and payment process for both students and clients, replacing the current fragmented and insecure informal methods. Key features should include user registration for both students and clients, service listing creation with categorization and portfolio samples, secure order placement and management, integrated in-platform messaging, secure payment handling with escrow for job protection, and a review/rating system to build credibility and trust in the marketplace.

This marketplace seeks to empower students by enabling them to monetize their abilities safely, providing a steady income source during their academic careers, while simultaneously offering clients affordable and verified services. The platform should aim to reduce inefficiencies, payment risks, and missed opportunities, and support entrepreneurship and economic growth within the student community."

## User Scenarios & Testing _(mandatory)_

### User Story 1 - Student publishes a service profile (Priority: P1)

Ethiopian university student signs up and publishes a service listing with portfolio samples so they can be discoverable by clients.

**Why this priority**: Without credible student listings, the marketplace cannot offer value to clients or generate income for students.

**Independent Test**: Create a new student account, complete profile, add at least one service listing with portfolio item, and confirm it appears in search results.

**Acceptance Scenarios**:

1. **Given** a new student user with a verified email and mobile number, **When** they complete university enrollment verification and submit required profile fields, **Then** the profile is marked "publish-ready" and becomes visible to clients.
2. **Given** a publish-ready student, **When** they create a listing with category selection, pricing, delivery timelines, and at least one portfolio sample, **Then** the listing is published and searchable within its category with accurate pricing displayed.
3. **Given** an existing listing, **When** the student edits content or availability, **Then** the listing updates immediately and audit history records the change for compliance review.

**Automated Tests**: Feature tests covering profile completion and listing publication, unit tests for validation rules, browser test validating multi-step form behavior and accessibility.

**UX Artefacts**: High-fidelity mockups for onboarding flow, form field guidance, and confirmation messaging; annotated screenshots for error states.

**Performance Acceptance**: Listing creation and publish confirmation must complete within 2 seconds client-side; listing search index updates must be reflected within 5 seconds (p95) of publish.

---

### User Story 2 - Client discovers and hires a student (Priority: P1)

Client registers, browses marketplace, filters listings, reviews profiles, and places an order with escrow payment for the selected student.

**Why this priority**: Client discovery and hiring drives revenue flow and validates the marketplace value proposition.

**Independent Test**: Create a client account, apply filters to find a listing, submit an order with escrow deposit, and confirm both parties receive notifications and the order dashboard updates.

**Acceptance Scenarios**:

1. **Given** a client account, **When** they search by category, skill tags, rating, and budget, **Then** results reflect filters, include relevant metadata (delivery time, reviews), and load within defined performance budgets.
2. **Given** a client viewing a listing, **When** they initiate an order and fund escrow with a defined scope, deliverables, milestones, and deadline, **Then** the order status is "Pending student response" and escrow holds the funds securely.
3. **Given** an order awaiting response, **When** the student accepts or declines with a reason, **Then** the client is notified instantly and order status transitions appropriately.

**Automated Tests**: Feature tests for search filters, order placement, and escrow creation; unit tests for pricing and availability calculations; browser tests for listing detail navigation and checkout steps.

**UX Artefacts**: Journey map for client discovery-to-order flow, responsive layouts for search results and order checkout, error state storyboard for failed payments.

**Performance Acceptance**: Search results must render first meaningful content within 1.5 seconds on median connections; order submission with escrow must complete within 3 seconds (p95) including confirmation messaging.

---

### User Story 3 - Order delivery, payment release, and review (Priority: P2)

Student delivers work, client reviews deliverables, payment is released from escrow, and both parties leave ratings to build marketplace trust.

**Why this priority**: Trusted fulfillment and transparent feedback ensure repeat usage and protect against disputes.

**Independent Test**: Progress an order through "In progress" to "Delivered", approve delivery, trigger escrow release to student, and capture post-order reviews.

**Acceptance Scenarios**:

1. **Given** an accepted order, **When** the student submits deliverables and marks the order "Delivered", **Then** the client receives notification with access to files and has the option to approve or request changes.
2. **Given** a delivered order, **When** the client approves within the defined review window, **Then** escrow releases funds to the student, both parties receive receipts, and order status updates to "Completed".
3. **Given** an order completion, **When** the client and student submit ratings and qualitative feedback, **Then** the review is stored, aggregated into profile metrics, and visible to future marketplace users within moderation guidelines.

**Automated Tests**: Feature tests for delivery submission, approval workflow, and review capture; unit tests for escrow release rules and rating aggregation; browser tests for messaging attachments and review forms.

**UX Artefacts**: Interaction prototypes for delivery review modal, payment confirmation, and rating prompts; accessibility annotations for screen reader flows.

**Performance Acceptance**: Delivery upload must handle files up to 50 MB with completion feedback within 5 seconds; escrow release confirmation must appear within 2 seconds after approval (p95).

---

### Edge Cases

-   Student attempts to publish a listing without mandatory verification documents or portfolio samples.
-   Client payment authorization fails or escrow cannot reserve funds; system must surface retry guidance without losing order details.
-   Student misses response deadline; order auto-expires and funds return to client.
-   Client disputes deliverables; order transitions into dispute mediation with frozen funds and restricted messaging until resolution.
-   Messaging attachments exceed size limits or contain disallowed file types.
-   Review submission contains flagged content requiring moderation before publication.

## Requirements _(mandatory)_

### Functional Requirements

-   **FR-001**: Platform MUST allow Ethiopian university students and clients to register distinct account types.
-   **FR-002**: IGNORE THIS FOR NOW (Student accounts MUST capture university enrollment verification (student ID upload or registrar code) before listings can be published.)
-   **FR-003**: Students MUST be able to create and maintain service listings with category selection, pricing, delivery timelines, scope description, and at least one portfolio sample (image, PDF, or link).
-   **FR-004**: Clients MUST be able to search, filter, and sort listings by category, skill tags, price range, delivery time, rating, and availability, with pagination for large result sets.
-   **FR-005**: Clients MUST be able to view consolidated student credibility signals (completion rate, average rating, reviews, verification status) on listing and profile pages before hiring.
-   **FR-006**: Feature MUST provide automated test coverage demonstrating the acceptance scenarios above (unit/feature/browser as appropriate).
-   **FR-007**: UX MUST remain consistent with shared Tailwind components and document visual states (success/loading/error) for QA sign-off.
-   **FR-008**: Feature MUST meet the declared performance budgets (default: backend ≤300 ms p95, UI ≤100 ms input feedback) with instrumentation notes.
-   **FR-009**: Clients MUST be able to submit orders that outline requirements, milestones, deadlines, and escrow amounts, with validation preventing incomplete submissions.
-   **FR-010**: Students MUST be able to accept or decline orders with optional reason codes, and the system MUST notify clients in real time.
-   **FR-011**: The platform MUST maintain order lifecycle states (Draft, Pending acceptance, In progress, Delivered, Revision requested, Completed, Disputed, Cancelled) and enforce state transitions according to business rules.
-   **FR-012**: Secure escrow payments MUST hold client funds upon order placement, restrict release until client approval or dispute resolution, and record transaction history for auditing.
-   **FR-013**: In-platform messaging MUST provide threaded conversations per order, support text plus file attachments up to 50 MB, and flag prohibited content for moderation review.
-   **FR-014**: Upon order completion or cancellation, the system MUST prompt both parties to submit ratings (1–5 stars) and qualitative feedback, updating aggregated scores within 5 seconds of submission.
-   **FR-015**: Notification system MUST deliver email and in-app alerts for key events (verification status, order actions, payment events, dispute updates) with configurable frequency.
-   **FR-016**: Administrative users MUST be able to review verification documents, resolve disputes, and override escrow releases while maintaining an audit trail of actions.

### Key Entities _(include if feature involves data)_

-   **StudentAccount**: IGNORE THIS FOR NOW (Verified university student profile with personal info, verification status, ratings summary, and linked service listings.)
-   **ClientAccount**: Individual or organization seeking services; stores contact info, payment methods, and order history.
-   **ServiceListing**: Student-offered service with category, pricing model, description, delivery timelines, tags, and publication status.
-   **PortfolioSample**: Media or links attached to a listing demonstrating previous work; includes metadata (type, thumbnail, description).
-   **Category**: Curated taxonomy of service areas (e.g., tutoring, design, development) used for browsing and analytics.
-   **Order**: Contract between client and student capturing scope, milestones, escrow amount, current status, deadlines, and linked messages.
-   **EscrowTransaction**: Record of funds held, released, or refunded with timestamps, amounts, and associated order.
-   **MessageThread**: Order-specific conversation containing messages, attachments, timestamps, and content flags.
-   **Review**: Feedback submitted post-order containing rating, text, and moderation status tied to both student and client profiles.
-   **DisputeCase**: Escalated order with dispute reason, evidence submissions, mediator assignments, and resolution outcome.

## Success Criteria _(mandatory)_

### Measurable Outcomes

-   **SC-001**: 85% of verified students can complete profile and publish a listing within 20 minutes of starting onboarding (measured via funnel analytics).
-   **SC-002**: Clients locate at least three relevant listings and place an order within 10 minutes in 90% of test sessions (usability testing + analytics).
-   **SC-003**: At least 80% of completed orders receive mutual reviews within 7 days, increasing marketplace credibility indicators.
-   **SC-004**: 95% of escrow payments release within 24 hours of client approval without manual intervention, and disputed funds remain frozen until resolved.
-   **SC-005**: All new automated tests for onboarding, search, ordering, messaging, payments, and reviews pass in CI, with coverage demonstrating success and failure paths.
-   **SC-006**: Marketplace search response time and order submission APIs meet ≤300 ms p95 latency under expected load, and client-facing UI interactions respond within 100 ms input feedback budget.

## Assumptions

-   Ethiopian universities provide verifiable student enrollment identifiers or document formats accepted during verification.
-   We will use stripe and stripe connect Preferred payment methods include local mobile money and bank cards supported by the payment provider capable of escrow operations.
-   Marketplace moderation team is available to review disputes, flagged messages, and suspicious reviews within 24 hours.
-   Default service categories and pricing ranges will be seeded by the business team prior to launch.

## Dependencies

-   Integration with payment gateway offering escrow, refund, and compliance features for Ethiopian market.
-   SMS/email messaging services for OTP verification and transactional notifications.
-   University verification API or manual review workflow to confirm student status.
-   Analytics tooling to capture funnel metrics, performance data, and success criteria measurements.
