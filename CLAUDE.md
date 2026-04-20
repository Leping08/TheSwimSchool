# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

TheSwimSchool is a Laravel 12 application for managing a swim school — group lessons, swim team registration/tryouts, private lessons, and payment processing. It uses Vue 2 for frontend interactivity, UIKit for the UI framework, Laravel Nova v5 for the admin panel, Stripe for payments, and deploys to AWS Lambda via Laravel Vapor.

## Common Commands

```bash
# Install dependencies
composer install
nvm use && npm install   # Node v15.14.0 via .nvmrc

# Development
php artisan serve        # Start local server
npm run dev              # Build frontend assets
npm run watch            # Watch for changes

# Testing
php artisan test                                # All tests
php artisan test --filter=TestClassName          # Single test class
php artisan test tests/Feature/SomeTest.php     # Single file

# Code formatting
vendor/bin/pint --dirty  # Format only changed files

# Production build
npm run production

# Deployment (Laravel Vapor)
vapor deploy production
vapor deploy staging
```

## Architecture

### Laravel Structure (Pre-Laravel 11)

This project upgraded from Laravel 10 to 12 **without** migrating to the new streamlined structure. This is intentional. Middleware is in `app/Http/Kernel.php`, exceptions in `app/Exceptions/Handler.php`, console in `app/Console/Kernel.php`, and rate limits in `RouteServiceProvider`.

### Domain Areas

The app has three main public-facing domains, each with its own controller namespace under `app/Http/Controllers/`:

- **Group Lessons** (`Groups/`) — Lesson browsing, schedule, signup, wait lists, certificates. Routes at `/lessons/*`.
- **Swim Team** (`SwimTeam/`) — Tryouts, athlete registration, roster, coach pages, meet schedules, records. Routes at `/swim-team/*`.
- **Private Lessons** (`Privates/`) — Private/semi-private lesson requests with calendar. Routes at `/private-semi-private`.

Additional controller areas: `Admin/` (instructor calendars), `Auth/`, and top-level controllers for contact, feedback, newsletter emails, and Stripe payment intents.

### Frontend

- **Laravel Mix** (`webpack.mix.js`) compiles Vue + SCSS from `resources/assets/` to `public/js` and `public/css`.
- **Vue 2 components** in `resources/assets/js/components/` — calendars, roster, promo codes, attendance tracking, email editing.
- **Blade templates** in `resources/views/`, organized by domain (groups, swim-team, auth, email, pages).
- **UIKit** is the CSS framework (not Tailwind or Bootstrap).

### Admin Panel

Laravel Nova v5 with ~37 resources in `app/Nova/`. Requires `auth.json` in project root for Nova package access.

### Key Integrations

- **Stripe** — Payment intents for lesson signups and swim team registration (`stripe/stripe-php`).
- **AWS S3** — Asset storage via `aws_asset()` helper (defined in `app/Http/Helpers.php`, autoloaded via composer).
- **Mailgun** — Email delivery.
- **Sidecar Browsershot** — PDF generation (certificates, records) via AWS Lambda.
- **Laravel Telescope** — Local debugging (disabled in tests).

### Database

75+ migrations. Key seeders: `DatabaseSeeder`, `ContactTypes`, `DaysOfTheWeek`, `SkillsSeeder`, `Seasons`. Tests use `.env.testing` for a separate test database config.

### Deployment

AWS Lambda via Laravel Vapor (`vapor.yml`). Two environments: production (`theswimschoolfl.com`) and staging (`staging.theswimschoolfl.com`). Build runs composer install, event cache, npm build. Deploy runs migrations and Sidecar deployment.

## Conventions

- Use `php artisan make:*` commands with `--no-interaction` to create new files.
- Use Form Request classes for validation (not inline in controllers).
- Prefer Eloquent over `DB::` facade. Use eager loading to prevent N+1 queries.
- Use `config()` helper, never `env()` directly outside config files.
- Use named routes and `route()` for URL generation.
- Always use curly braces for control structures, even single-line.
- Use PHP 8 constructor property promotion.
- Use explicit return type declarations and type hints.
- Run `vendor/bin/pint --dirty` before finalizing PHP changes.
