# Quickstart (Feature)

## Prerequisites

-   PHP 8.2+, Composer
-   MySQL 8
-   Redis (for queues)
-   Node 18+ and PNPM
-   Stripe account + Connect (Standard) enabled

## Setup

1. Copy .env and set:
    - DB\_\* for MySQL
    - REDIS\_\* for queues
    - STRIPE_KEY, STRIPE_SECRET, STRIPE_WEBHOOK_SECRET
    - APP_TIMEZONE=Africa/Addis_Ababa
    - CURRENCY=ETB
2. Install dependencies and build assets using PNPM:

```
pnpm install
pnpm run build
```

3. Migrate DB and start services:

```
php artisan migrate
php artisan serve
php artisan horizon
```

4. Run tests:

```
php artisan test
```

## Notes

-   Use `php artisan queue:work` in non-Horizon environments.
-   Ensure webhook route `/stripe/webhook` is configured and signed.
