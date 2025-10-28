# FP Test One Development Guidelines

Auto-generated from feature plans. Last updated: 2025-10-13

## Active Technologies

-   Laravel 12 (PHP 8.2)
-   MySQL 8
-   Redis + Laravel Horizon
-   Stripe + Stripe Connect (Standard)
-   Laravel Sanctum (API auth)
-   Spatie Laravel Permission (RBAC)
-   Scribe (API docs)
-   PNPM + Vite (frontend assets)

## Project Structure (planned feature modules)

```
app/
├── Models/
├── Services/
├── Repositories/
├── Policies/
├── Http/
│   ├── Controllers/
│   └── Requests/
└── Events/ Listeners/ Jobs/

routes/
├── api.php
└── web.php
```

## Commands

-   pint: vendor/bin/pint
-   tests: php artisan test
-   queues: php artisan horizon (or queue:work)
-   assets: pnpm install && pnpm run dev

## Code Style

-   PSR-12 via Laravel Pint
-   Public methods/constructors declare parameter and return types
-   Avoid mixed/array in public APIs; use DTOs where needed

## Recent Changes

-   005-build-a-student: Added plan, research, data model, OpenAPI skeleton, quickstart.

<!-- MANUAL ADDITIONS START -->
<!-- MANUAL ADDITIONS END -->
