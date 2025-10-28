# Quickstart: Student Skills Marketplace Platform

## Prerequisites

- PHP 8.2+
- Composer 2.6+
- Node.js 20 LTS + PNPM 9+
- MySQL 8.x (local or Docker)
- Redis 7.x
- Meilisearch 1.7+
- Stripe account with Connect enabled (test mode)
- AWS S3 bucket (or MinIO) for asset storage
- Powershell/Bash with Make or equivalent task runner

## 1. Clone & Install Dependencies

```bash
# clone repository and checkout feature branch
git clone <repo-url> student-marketplace && cd student-marketplace
git checkout 002-build-a-student

# install backend dependencies
composer install

# install frontend dependencies with pnpm
pnpm install
```

## 2. Environment Configuration

```bash
cp .env.example .env
php artisan key:generate
```

Update `.env` with:
- `APP_URL`, `APP_ENV`, `APP_DEBUG`
- Database credentials (`DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`)
- Redis connection (`REDIS_HOST`, `REDIS_PASSWORD`)
- Meilisearch host/key (`MEILISEARCH_HOST`, `MEILISEARCH_KEY`)
- Stripe keys (`STRIPE_KEY`, `STRIPE_SECRET`, `STRIPE_WEBHOOK_SECRET`)
- Stripe Connect settings (`STRIPE_CONNECT_CLIENT_ID`, `STRIPE_CONNECT_SECRET`, `STRIPE_APPLICATION_FEE_PERCENT`)
- AWS S3 (or MinIO) storage (`AWS_ACCESS_KEY_ID`, `AWS_SECRET_ACCESS_KEY`, `AWS_DEFAULT_REGION`, `AWS_BUCKET`, `AWS_URL`)
- Queue + websockets configuration (`BROADCAST_DRIVER=pusher`, `PUSHER_*` for Laravel WebSockets)

## 3. Database & Storage Setup

```bash
php artisan migrate --seed
php artisan storage:link
```

- Seeds provision default roles (student, client, admin), categories, and sample data for testing.
- Configure MySQL with utf8mb4 collation, time zone Africa/Addis_Ababa.

## 4. Stripe Connect Configuration

1. Enable Connect in Stripe dashboard.
2. Create a Connect application, capture the client ID and secret.
3. Configure webhook endpoints for:
   - `payment_intent.succeeded`
   - `payment_intent.payment_failed`
   - `transfer.paid`
   - `transfer.failed`
   - `account.updated`
   - `charge.dispute.created`
4. Run Stripe CLI in test mode for local development:

```bash
stripe login
stripe listen --forward-to http://localhost:8000/stripe/webhook
```

## 5. Run Local Services

```bash
# start Laravel development server
php artisan serve

# run queue workers and websockets
php artisan horizon &
php artisan websockets:serve &

# start Meilisearch (example Docker command)
docker run -it --rm -p 7700:7700 getmeili/meilisearch:v1.7

# run Vite dev server with pnpm
pnpm run dev
```

- Configure supervisors (e.g., Laravel Horizon, websockets) in production using systemd or Docker compose.

## 6. Build & Test

```bash
# backend tests
php artisan test --parallel

# static analysis & formatting
vendor/bin/pint --test

# Playwright end-to-end tests
pnpm run test:e2e

# Frontend unit tests
pnpm run test:unit
```

## 7. Recommended Packages & Usage

| Purpose | Package | Notes |
|---------|---------|-------|
| Authentication & onboarding | `laravel/fortify`, `laravel/sanctum` | Fortify for password/2FA flows; Sanctum for session+token auth |
| Role-based access control | `spatie/laravel-permission` | Map roles `student`, `client`, `admin` and granular policies |
| Payments | `laravel/cashier` + `stripe/stripe-php` | Extend Cashier for Connect transfers/escrow management |
| Search | `laravel/scout` + `meilisearch/meilisearch-php` | Index listings, profiles, categories |
| Queues & monitoring | `laravel/horizon` | Track jobs for payouts, notifications |
| Websockets | `beyondcode/laravel-websockets` | Real-time messaging & notifications |
| Messaging UI | `inertiajs/inertia-laravel`, `@inertiajs/vue3`, `@headlessui/vue` | Build interactive dashboards |
| File uploads | `league/flysystem-aws-s3-v3` | S3/MinIO storage driver |
| API documentation | `knuckleswtf/scribe` | Generate API docs for client/mobile consumers |
| Mail & notifications | built-in Laravel Mail/Notifications + `laravel-notification-channels/telegram` (optional) | Multi-channel notifications |
| Activity logging | `spatie/laravel-activitylog` | Capture audit trails |

## 8. Development Workflow

1. Create feature branches from `002-build-a-student` or future mainline.
2. Ensure linting (`vendor/bin/pint --test`, `pnpm run lint`) and tests pass before PR.
3. Provide UX artefacts (screenshots/gifs) and performance evidence in pull requests.
4. Use `php artisan data:sync` (to be implemented) for syncing lookup tables.
5. Run `php artisan scout:import "App\Models\ServiceListing"` after seeding to populate Meilisearch.

## 9. Deployment Notes

- Package application using Docker with PHP-FPM + Nginx; run separate containers for queue workers, websockets, Meilisearch, and Horizon.
- Configure `.env` secrets via secure secret manager (e.g., AWS SSM, Azure Key Vault).
- Schedule cron for `php artisan schedule:run` to manage escrow release checks and reminder emails.
- Enforce HTTPS, HSTS, and secure cookie settings.
- Monitor Stripe webhooks and Horizon dashboards; set alerts for job failures and payment disputes.
