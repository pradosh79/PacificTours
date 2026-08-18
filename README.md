# Pacific Tours Canada — Travel & Tour Management System

Production-grade Laravel 12 platform for a Canadian tour operator: catalogue,
availability, a five-step booking wizard, payments with deposits and refunds, a
role-based back office, a customer portal, CMS, reporting, and a JSON API.

**The design constraint that shaped everything:** the storefront will be replaced
later by an approved Figma design. So no business logic lives in a view, route
names are treated as a public contract, and the API can do everything the Blade
frontend can. See [`docs/FIGMA-INTEGRATION.md`](docs/FIGMA-INTEGRATION.md).

---

## Read this first

This repository contains the **application layer** — `app/`, `database/`,
`routes/`, `resources/`, `config/`, `tests/`, `bootstrap/app.php`, and the
project manifests. It does **not** include `vendor/`, `node_modules/` or the
stock Laravel skeleton files, because the build environment had no access to
Packagist.

Setup is therefore two steps rather than one:

```bash
# 1. Create a fresh Laravel 12 skeleton
composer create-project laravel/laravel pacific-tours "12.*"

# 2. Copy this delivery over it (overwriting where they overlap)
rsync -a delivery/ pacific-tours/

cd pacific-tours
composer install
npm install
```

The required packages are already declared in `composer.json`:
`spatie/laravel-permission`, `laravel/sanctum`, `barryvdh/laravel-dompdf`,
`maatwebsite/excel`, `stripe/stripe-php`, `spatie/laravel-activitylog`,
`spatie/laravel-backup`, `spatie/laravel-sitemap`, `intervention/image`,
`predis/predis`.

Then publish the vendor config that ships with them:

```bash
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan vendor:publish --tag=sanctum-migrations
```

---

## Quick start

```bash
cp .env.example .env
php artisan key:generate
# set DB_*, REDIS_*, MAIL_*, STRIPE_* in .env

php artisan migrate --seed     # DemoDataSeeder runs in local/staging only
php artisan storage:link
npm run build

php artisan serve
php artisan queue:work redis --queue=payments,notifications,default
```

Seeded super admin: `admin@pacifictours.ca` / `ChangeMe!2026` —
**change it immediately.**

| URL | What |
|---|---|
| `/` | storefront (placeholder theme) |
| `/admin` | back office (production theme) |
| `/customer` | customer portal (placeholder theme) |
| `/api/v1/tours` | API |

---

## Documentation

| Document | Contents |
|---|---|
| **[docs/ARCHITECTURE.md](docs/ARCHITECTURE.md)** | The full analysis — all 26 required sections: folder structure, ERD, migration order, tables, relationships, models, controllers, repositories, services, routes, middleware, policies, events, notifications, jobs, both dashboards, booking and payment workflows, placeholder pages, API, Figma strategy, deployment, optimization, security, testing |
| [docs/erd.mermaid](docs/erd.mermaid) | Complete entity relationship diagram with every column |
| [docs/API.md](docs/API.md) | API v1 reference with request/response examples |
| [docs/FIGMA-INTEGRATION.md](docs/FIGMA-INTEGRATION.md) | Handover contract for the design team — three migration paths, view variables, acceptance checklist |
| [docs/DEPLOYMENT.md](docs/DEPLOYMENT.md) | Ubuntu runbook: Nginx, Supervisor, cron, gateways, zero-downtime deploys, go-live checklist |
| [docs/SECURITY-CHECKLIST.md](docs/SECURITY-CHECKLIST.md) | Built vs. operator responsibilities, plus pre-launch penetration checks |
| [docs/TESTING-STRATEGY.md](docs/TESTING-STRATEGY.md) | What is tested, why those things, coverage targets, CI gates |

---

## Architecture at a glance

```
Request → Route → Middleware → Form Request → Controller
                                                  │
                                                  ▼
                                    Service  (all business logic)
                                       │
                        ┌──────────────┼──────────────┐
                        ▼              ▼              ▼
                  Repository        Event         Gateway
                        │              │
                        ▼              ▼
                     Model      Listener → Job / Notification
                        │
                        ▼
                    Database
```

**Three decisions worth knowing before you read the code:**

1. **Seats live on `tour_departures`, never on tours.** The booking transaction
   locks that row with `SELECT … FOR UPDATE`, so two simultaneous checkouts
   serialise instead of overselling. `SeatConcurrencyTest` proves it.
2. **`PricingService` is the single source of truth for money.** The wizard, the
   admin form and the API all quote through it, and `PaymentService` recomputes
   the amount rather than trusting the gateway. The number a customer sees and
   the number charged cannot diverge.
3. **`bookings` freezes its prices and its customer.** Both are columns, not
   joins — so editing a tour tomorrow cannot alter what someone agreed to today,
   and guest checkout needs no account.

---

## Roles

| Role | Reach |
|---|---|
| Super Admin | everything, bypasses all gates |
| Admin | everything except destructive user management |
| Manager | tours, bookings, payments, CMS, reports |
| Sales Executive | bookings, customers, record payments |
| Tour Operator | **only tours they created**, plus related bookings |
| Customer | own bookings, invoices, wishlist, reviews, tickets |

Permissions are generated from `config/permission_map.php`, so adding a
capability is one line plus a reseed.

---

## Testing

```bash
php artisan test --parallel
vendor/bin/pint --test
vendor/bin/phpstan analyse
```

Feature tests run against MySQL, not SQLite — row locking and FULLTEXT are
exactly what is under test.

---

## Known gaps

Honest list of what a follow-up sprint should pick up. Everything from the
previous gap list has been closed; these are what remain:

- **2FA needs Fortify's TOTP provider installed.** Schema, routes, challenge
  controller and Blade view are all in place; `TwoFactorController` type-hints
  `Laravel\Fortify\Contracts\TwoFactorAuthenticationProvider`, so
  `composer require laravel/fortify` completes it.
- **No WYSIWYG editor is wired.** Long-form fields carry a `data-editor`
  attribute as the hook; drop in TinyMCE or Trix and target that selector.
- **Menu drag-and-drop is server-ready but not wired client-side.** The
  `POST /admin/menus/{menu}/reorder` endpoint accepts a flat
  `{id, parent_id, sort_order}` array; the tree renders with `data-id`
  attributes ready for SortableJS.
- **Multi-currency converts for display only.** By design — see the docblock on
  `CurrencyService`. Charging in a non-base currency needs gateway-side
  multi-currency accounts and a rate-locking decision first.
- **No Dusk browser suite** (see `docs/TESTING-STRATEGY.md` for the plan).
- **Exchange rates are entered by hand** in Admin → Currencies. A scheduled job
  against a rates API would be a small addition.
- **Widget content is edited as raw JSON.** Functional, but a per-widget-type
  form would be kinder to non-technical staff.
