# Quickstart

## Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js 18+
- PNPM
- MySQL 8.0+
- Redis (for queues and sessions)

## Installation
1. Clone the repository: `git clone <repo-url>`
2. Install PHP dependencies: `composer install`
3. Copy environment file: `cp .env.example .env`
4. Configure `.env`:
   - Database: DB_CONNECTION=mysql, DB_HOST=127.0.0.1, DB_PORT=3306, DB_DATABASE=marketplace, DB_USERNAME=, DB_PASSWORD=
   - Stripe: STRIPE_KEY=, STRIPE_SECRET=, STRIPE_WEBHOOK_SECRET=
   - Queue: QUEUE_CONNECTION=redis, REDIS_HOST=127.0.0.1
5. Generate application key: `php artisan key:generate`
6. Run migrations: `php artisan migrate`
7. Install Node dependencies: `pnpm install`
8. Build assets: `pnpm run build`

## Running the Application
- Start the server: `php artisan serve`
- Start queue worker: `php artisan queue:work`
- For development assets: `pnpm run dev`

## Additional Setup
- Configure Stripe Connect for payouts
- Set up mail driver for notifications
- Run tests: `php artisan test`