# Data Model

## Entities

### User
- id: integer, primary key
- name: string, required
- email: string, unique, required
- password: string, hashed
- role: enum (buyer, seller), default buyer
- stripe_account_id: string, nullable
- created_at, updated_at

Relationships: hasMany Listings, hasMany Orders (as buyer), hasMany Reviews

Validation: email format, password min 8

### Skill
- id: integer, primary key
- name: string, required, unique
- category: string, required
- created_at, updated_at

Relationships: hasMany Listings

Validation: name unique

### Listing
- id: integer, primary key
- user_id: integer, foreign key to User
- skill_id: integer, foreign key to Skill
- title: string, required
- description: text, required
- price: decimal(10,2), required, >0
- status: enum (draft, published, inactive), default draft
- created_at, updated_at

Relationships: belongsTo User, belongsTo Skill, hasMany Orders

Validation: price >0

State transitions: draft -> published (by seller), published -> inactive (by seller or admin), published -> sold (after order)

### Order
- id: integer, primary key
- buyer_id: integer, foreign key to User
- listing_id: integer, foreign key to Listing
- amount: decimal(10,2), required
- status: enum (pending, paid, completed, cancelled, refunded), default pending
- created_at, updated_at

Relationships: belongsTo User (buyer), belongsTo Listing, hasOne Payment, hasOne Review

Validation: amount >0

State transitions: pending -> paid (after payment), paid -> completed (after delivery), paid -> refunded

### Payment
- id: integer, primary key
- order_id: integer, foreign key to Order
- stripe_payment_id: string, required
- amount: decimal(10,2), required
- status: enum (pending, succeeded, failed), default pending
- created_at, updated_at

Relationships: belongsTo Order

### Review
- id: integer, primary key
- order_id: integer, foreign key to Order
- rating: integer, 1-5, required
- comment: text, nullable
- created_at, updated_at

Relationships: belongsTo Order, belongsTo User (via order)

Validation: rating 1-5