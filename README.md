# Developer Portfolio — Laravel 13 + Vue 3 + MySQL

A professional, full-stack developer portfolio built to showcase work to international companies.
It pairs a clean, layered Laravel REST API (backed by MySQL) with a modern, dark-themed Vue 3 +
TypeScript single-page application, plus an admin panel to manage all content without touching code.

The codebase is written with **OOP, SOLID principles, and clean architecture** in mind:
thin controllers delegate to **services** (business logic) which depend on **repository interfaces**
(persistence), and every response flows through a consistent JSON envelope.

---

## Tech Stack

| Layer      | Technology                                                        |
| ---------- | ----------------------------------------------------------------- |
| Backend    | Laravel 13, PHP 8.3+, Laravel Sanctum (token auth)                |
| Database   | MySQL 8                                                           |
| Frontend   | Vue 3 (`<script setup>`), TypeScript, Vite, Pinia, Vue Router      |
| Styling    | Tailwind CSS v4 (custom dark theme)                               |
| Tooling    | Spatie Media Library & Query Builder, PHPUnit                     |

---

## Architecture

```
Request
  │
  ▼
routes/api.php ──► Controller (Api/*, Api/Admin/*)   thin, HTTP-only
                      │  ├─ Form Request      validation
                      │  ├─ Service           business logic  (app/Services)
                      │  │     └─ Repository interface  (app/Repositories/Contracts)
                      │  │            └─ Eloquent repo   (app/Repositories/Eloquent)
                      │  └─ API Resource      output shaping   (app/Http/Resources)
                      ▼
              ApiResponse envelope  { success, message, data, errors }
```

Key principles applied:

- **Single Responsibility / Layered** — controllers stay thin; logic lives in services; data access lives in repositories.
- **Dependency Inversion** — services depend on repository *interfaces*, bound to Eloquent implementations in [`app/Providers/RepositoryServiceProvider.php`](app/Providers/RepositoryServiceProvider.php).
- **Open/Closed & consistency** — a shared [`BaseRepository`](app/Repositories/Eloquent/BaseRepository.php), a base [`ApiController`](app/Http/Controllers/Api/ApiController.php), and a centralized [`ApiResponse`](app/Http/Responses/ApiResponse.php) + exception handling in [`bootstrap/app.php`](bootstrap/app.php).
- **DTOs** — inbound data is modeled explicitly (e.g. [`ContactMessageData`](app/DataTransferObjects/ContactMessageData.php)).

### Directory highlights

```
app/
├── DataTransferObjects/      # Immutable input DTOs
├── Enums/                    # SkillCategory
├── Http/
│   ├── Controllers/Api/      # Public + Admin controllers
│   ├── Requests/             # Form Request validation
│   ├── Resources/            # API Resource transformers
│   └── Responses/ApiResponse # Uniform JSON envelope
├── Mail/                     # Queued contact notification
├── Models/                   # Eloquent models
├── Repositories/
│   ├── Contracts/            # Interfaces (DIP)
│   └── Eloquent/             # Implementations
└── Services/                 # Business logic
resources/js/                 # Vue 3 + TS SPA (public site + admin)
```

---

## Getting Started

### Prerequisites

- PHP 8.3+, Composer
- Node.js 20+, npm
- MySQL 8

### Setup

```bash
# 1. Install dependencies
composer install
npm install

# 2. Environment
cp .env.example .env        # if starting fresh
php artisan key:generate

# 3. Configure the database in .env
#    DB_CONNECTION=mysql
#    DB_DATABASE=portfolio
#    DB_USERNAME=root
#    DB_PASSWORD=your_password
mysql -u root -p -e "CREATE DATABASE portfolio CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# 4. Migrate + seed (loads the featured case studies, skills, profile & admin user)
php artisan migrate --seed

# 5. Storage symlink (for uploaded images / CV)
php artisan storage:link

# 6. Run
npm run dev          # Vite dev server (terminal 1)
php artisan serve    # Laravel  (terminal 2)  → http://127.0.0.1:8000
```

For production, build the assets instead of running the dev server:

```bash
npm run build
```

### Default admin credentials (from the seeder)

```
Email:    admin@portfolio.test
Password: password
```

Admin panel: `/admin/login`. **Change this password after first login (or in the seeder).**

---

## Editing Your Content

Everything on the public site is data-driven and editable from the admin panel at `/admin` — no code changes required:

| Section        | Where to edit                                                             |
| -------------- | ------------------------------------------------------------------------- |
| Name / bio / socials / stats / CV | `profiles` table — seeded in [`ProfileSeeder`](database/seeders/ProfileSeeder.php); update the placeholders (`Your Name`, emails, GitHub/LinkedIn URLs). Also exposed via the admin profile API. |
| Projects / case studies | Admin → Projects (create, edit, reorder, publish, attach tech stack, metrics, highlights). Seed data in [`ProjectSeeder`](database/seeders/ProjectSeeder.php). |
| Skills         | Admin → Skills (grouped by category with proficiency levels).             |
| Experience     | Admin → Experience (timeline entries).                                    |
| Messages       | Admin → Messages (inbound contact-form submissions).                      |

To update the identity placeholders quickly, edit [`database/seeders/ProfileSeeder.php`](database/seeders/ProfileSeeder.php) and re-run:

```bash
php artisan db:seed --class=ProfileSeeder
```

### Contact email notifications

Contact submissions are stored in the database and a queued email is sent to your profile email
(falling back to `MAIL_FROM_ADDRESS`). Configure SMTP in `.env` and run a queue worker
(`php artisan queue:work`) to deliver them. With `QUEUE_CONNECTION=sync` they send immediately.

---

## API Overview

Public (no auth):

| Method | Endpoint                | Description                        |
| ------ | ----------------------- | ---------------------------------- |
| GET    | `/api/site`             | Aggregated landing-page payload    |
| GET    | `/api/profile`          | Profile / identity                 |
| GET    | `/api/skills`           | All skills                         |
| GET    | `/api/projects`         | Published projects (`?skill=`, `?category=`) |
| GET    | `/api/projects/{slug}`  | Single case study                  |
| GET    | `/api/experiences`      | Experience timeline                |
| GET    | `/api/testimonials`     | Testimonials                       |
| POST   | `/api/contact`          | Submit contact form (throttled + honeypot) |

Admin (`auth:sanctum`): `POST /api/admin/login`, plus CRUD under `/api/admin/{projects,skills,experiences,testimonials}`, `/api/admin/profile`, `/api/admin/messages`, and `/api/admin/dashboard`.

---

## Testing

```bash
# Create the test database once
mysql -u root -p -e "CREATE DATABASE portfolio_test CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

php artisan test
```

The suite covers project listing/filtering, the contact flow (validation, honeypot, queued mail),
admin authentication and authorization, the `ProjectService`, and unit tests for enums and DTOs.

---

## License

MIT — feel free to adapt this for your own portfolio.
