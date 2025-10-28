# Data Model (Phase 1)

## Entities

-   User (extends default):

    -   id, name, email, role: enum[student, client, admin], rating_avg, rating_count

-   StudentProfile:

    -   user_id (unique), skills (json), bio (text), education (json), portfolio_url (nullable)

-   Category:

    -   id, name, slug

-   ServiceListing:

    -   id, student_user_id, category_id, title, description, price_cents (int), currency (ETB), delivery_days (int), is_published (bool), rating_avg, rating_count

-   PortfolioItem:

    -   id, user_id, listing_id (nullable), title, description, media_path/url, type (image, video, link)

-   Order:

    -   id, client_user_id, student_user_id, listing_id, scope (text), requirements (json), budget_cents, currency, deadline_at (datetime), state (enum: draft, pending_funding, awaiting_acceptance, in_progress, in_review, completed, canceled, disputed), due_at (nullable), auto_approve_at (nullable)

-   Payment:

    -   id, order_id, stripe_payment_intent_id, stripe_transfer_id (nullable), amount_cents, currency, status (requires_payment_method, requires_confirmation, processing, succeeded, canceled), last_error (json), captured_at, refunded_cents (int)

-   MessageThread:

    -   id, context_type (inquiry|order), context_id (listing_id|order_id), created_by_id

-   Message:

    -   id, thread_id, sender_id, body (text), attachments (json), flagged (bool)

-   Review:

    -   id, order_id, author_id, subject_user_id, rating (1-5), comment, created_at

-   Dispute:
    -   id, order_id, reason, status (open, negotiating, resolved_refund, resolved_release), resolution_notes

## Relationships

-   User 1-1 StudentProfile
-   User 1-N ServiceListing (as student)
-   Listing N-1 Category
-   Order N-1 Listing; Order belongs to Client and Student (both User)
-   Payment 1-1 Order
-   Thread polymorphic to Inquiry (Listing) or Order
-   Message N-1 Thread
-   Review N-1 Order; Review authored by one party about the other

## Validation Rules (high-level)

-   Listing: title [min 5, max 100], price_cents ≥ 1000 (ETB 10), delivery_days 1–60
-   Order: budget_cents ≥ listing price; deadline_at in future; scope required
-   Payment: amount matches order budget; currency = ETB
-   Review: one per party per order; rating 1–5

## Indexes

-   service_listings: (category_id), (is_published), (student_user_id), fulltext(title, description)
-   orders: (client_user_id), (student_user_id), (state), (listing_id)
-   payments: (order_id), (stripe_payment_intent_id unique)
-   reviews: (subject_user_id)
-   messages: (thread_id, created_at)
