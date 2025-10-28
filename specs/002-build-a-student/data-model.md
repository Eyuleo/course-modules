# Data Model: Student Skills Marketplace Platform

## Overview

Defines core domain entities, their attributes, relationships, and validation constraints supporting student listings, orders, escrow payments, messaging, and reviews.

## Entities

### StudentAccount
- **Primary Key**: id (UUID)
- **Attributes**: user_id (FK), university_name, student_id_number, enrollment_status, verification_status (pending|approved|rejected), biography, skills (JSON array), hourly_rate, availability_status, completion_rate, average_rating, profile_published_at.
- **Relationships**: belongs to User; has many ServiceListings, Orders (as provider), Reviews (as recipient), PortfolioSamples.
- **Validation**: student_id_number required & unique; university_name required; verification_status transitions require admin action; hourly_rate numeric ≥ 0.

### ClientAccount
- **Primary Key**: id (UUID)
- **Attributes**: user_id (FK), organization_name (nullable), contact_phone, verification_status, default_currency, billing_address (JSON), preferred_categories (JSON array).
- **Relationships**: belongs to User; has many Orders (as purchaser), Reviews (as author).
- **Validation**: contact_phone required; default_currency ISO 3-letter; verification_status flows via KYC.

### User
- **Primary Key**: id (ULID)
- **Attributes**: name, email (unique), phone_number (unique), password_hash, role (student|client|admin), two_factor_enabled, last_login_at, locale.
- **Relationships**: morphTo provider profile (student or client), belongs to many roles via Spatie permissions.
- **Validation**: email RFC compliant; phone E.164; enforce role assignment at creation.

### ServiceListing
- **Primary Key**: id (ULID)
- **Attributes**: student_account_id (FK), title, slug (unique), category_id, description, base_price, price_unit (hour|project), delivery_time_days, status (draft|published|paused), search_vector (Scout index), tags (JSON array), revision_policy, portfolio_preview_media_id (FK optional).
- **Relationships**: belongs to StudentAccount; belongs to Category; has many PortfolioSamples; has many Orders; searchable via Scout/Meilisearch.
- **Validation**: title 10–120 chars; base_price ≥ 0; delivery_time_days 1–60; status transitions enforce verification.

### Category
- **Primary Key**: id (auto-increment)
- **Attributes**: name (unique), slug, description, icon, parent_id (nullable).
- **Relationships**: has many ServiceListings; supports hierarchical taxonomy.

### PortfolioSample
- **Primary Key**: id (ULID)
- **Attributes**: service_listing_id (FK), file_path, thumbnail_path, media_type (image|pdf|link|video), title, description, visibility (public|private), uploaded_at.
- **Relationships**: belongs to ServiceListing.
- **Validation**: file_path required unless media_type=link; enforce file size ≤ 50 MB.

### Order
- **Primary Key**: id (ULID)
- **Attributes**: client_account_id (FK), student_account_id (FK), service_listing_id (FK optional), title, scope_summary, requirements (JSON), milestone_plan (JSON array), budget_amount, currency, escrow_transaction_id (FK), status (draft|pending|accepted|declined|in_progress|delivered|revision_requested|completed|disputed|cancelled), expires_at, accepted_at, delivered_at, completed_at.
- **Relationships**: belongs to ClientAccount; belongs to StudentAccount; belongs to ServiceListing; has one EscrowTransaction; has many Messages; has many DisputeCase entries; has many Attachments.
- **Validation**: budget_amount ≥ minimum listing price; deadlines consistent with listing delivery_time; status transitions guarded by policies.

### EscrowTransaction
- **Primary Key**: id (ULID)
- **Attributes**: order_id (FK), stripe_payment_intent_id, stripe_transfer_id (nullable), amount, currency, fee_amount, status (pending|held|released|refunded|disputed), captured_at, released_at, refunded_at, failure_reason.
- **Relationships**: belongs to Order.
- **Validation**: amount matches order budget; ensure status transitions follow Stripe webhooks.

### MessageThread
- **Primary Key**: id (ULID)
- **Attributes**: order_id (FK), subject, last_message_at.
- **Relationships**: belongs to Order; has many Messages.

### Message
- **Primary Key**: id (ULID)
- **Attributes**: thread_id (FK), sender_id (User FK), body, attachment_path (nullable), attachment_type, sent_at, status (sent|delivered|read), moderation_flag (nullable), deleted_at.
- **Relationships**: belongs to MessageThread; belongs to User.
- **Validation**: body required unless attachment; enforce file size ≤ 50 MB; attachments virus scanned before marking delivered.

### Review
- **Primary Key**: id (ULID)
- **Attributes**: order_id (FK), reviewer_id (User FK), subject_user_id (User FK), rating (1–5), comment, moderation_status (pending|approved|rejected), submitted_at, published_at.
- **Relationships**: belongs to Order; belongs to reviewer (User); belongs to subject user (User).
- **Validation**: order status must be completed; rating integer 1–5; comment optional up to 1,000 chars.

### DisputeCase
- **Primary Key**: id (ULID)
- **Attributes**: order_id (FK), raised_by_user_id, reason_code, description, evidence_links (JSON), status (open|under_review|resolved|cancelled), resolution_notes, resolved_at.
- **Relationships**: belongs to Order; belongs to raising User; has many DisputeEvents.

### DisputeEvent
- **Primary Key**: id (ULID)
- **Attributes**: dispute_case_id (FK), actor_id (User FK or system), action_type (message|evidence|decision), payload (JSON), occurred_at.

### NotificationPreference
- **Primary Key**: id (ULID)
- **Attributes**: user_id (FK), channel (email|sms|in_app|push), event_type, enabled (bool).
- **Relationships**: belongs to User.

### AuditLog
- **Primary Key**: id (ULID)
- **Attributes**: actor_id (User FK or system), action, target_type, target_id, changes (JSON), ip_address, occurred_at.

## State Machines

### StudentAccount Verification
`pending -> approved -> (suspended|approved)`
- Admin transitions to approved after manual review.
- Suspended occurs if documentation expires; returns to pending on re-upload.

### Order Lifecycle
`draft -> pending -> accepted -> in_progress -> delivered -> (revision_requested -> in_progress)* -> completed`
- Declined path: `pending -> declined` with auto-refund.
- Dispute path: any of `in_progress|delivered|revision_requested -> disputed -> resolved (completed|cancelled)`.
- Cancellation: `pending|accepted|in_progress -> cancelled` per policy.

### EscrowTransaction
`pending -> held -> released` or `pending -> failed` or `held -> refunded` or `held -> disputed -> refunded/released`.

## Data Integrity & Indexing
- Unique indexes on user email, phone, service listing slug, Stripe identifiers.
- Composite indexes for search facets: category_id + status, student_account_id + status.
- Soft deletes on messages, listings, and users for compliance audits.
- Foreign key constraints enforced with cascading restrict on destructive actions.

## Compliance Considerations
- Store verification documents securely (encrypted at rest) with access logging.
- Retain financial transactions for minimum 7 years.
- Ensure GDPR-like data export/delete workflows for users while preserving order audit trail.
