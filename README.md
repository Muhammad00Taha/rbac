# Role-Based Access Control (RBAC) System - Laravel

A comprehensive Laravel application implementing Role-Based Access Control (RBAC) using the Spatie Laravel Permission package. This system features secure authentication, granular permission management, and a modern UI with server-side DataTables, Select2 dropdowns, and SweetAlert2 notifications.

---

## Table of Contents

- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Database Setup](#database-setup)
- [Running the Application](#running-the-application)
- [Default Credentials](#default-credentials)
- [Architecture Overview](#architecture-overview)
- [Features](#features)
- [Testing](#testing)
- [Project Structure](#project-structure)

---

## Prerequisites

Before you begin, ensure your development environment meets the following requirements:

- **PHP**: `>= 8.2`
- **Composer**: Latest version
- **Laravel Framework**: `^12.0`
- **Database**: MySQL `>= 8.0` or PostgreSQL `>= 13.0` or SQLite `>= 3.35`
- **Node.js**: `>= 18.x`
- **NPM**: `>= 9.x` (or Yarn `>= 1.22`)
- **Web Server**: Apache or Nginx (or use `php artisan serve` for local development)

---

## Installation

Follow these steps to set up the project on your local machine:

### 1. Clone the Repository

```bash
git clone <repository-url>
cd rbac
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install JavaScript Dependencies

```bash
npm install
```

### 4. Environment Configuration

Copy the example environment file and configure it:

```bash
cp .env.example .env
```

Edit the `.env` file and configure your database connection:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rbac
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

---

## Database Setup

### 1. Run Migrations

Execute the migrations to create all necessary database tables:

```bash
php artisan migrate
```

This will create the following tables:
- `users` - User accounts
- `roles` - System roles (Admin, Manager, User)
- `permissions` - Granular permissions
- `model_has_roles` - User-role assignments
- `model_has_permissions` - User-permission assignments
- `role_has_permissions` - Role-permission assignments
- `sections` - Section entities
- `classes` - Class entities (with section relationships)

### 2. Seed the Database

Populate the database with default roles, permissions, and test users:

```bash
php artisan db:seed
```

**What gets seeded:**
- **Roles**: Admin, Manager, User
- **Permissions**: Complete set of permissions for users, profiles, sections, and classes
- **Users**: 
  - Admin user: `admin@example.com` / `password`
  - Manager user: `manager@example.com` / `password`
  - Standard user: `user@example.com` / `password`
  - 10 additional random users with randomly assigned roles

### 3. (Optional) Fresh Migration with Seeding

To reset the database and seed it in one command:

```bash
php artisan migrate:fresh --seed
```

---

## Running the Application

### Development Server

#### Option 1: Laravel Built-in Server

```bash
php artisan serve
```

The application will be available at: `http://127.0.0.1:8000`

#### Option 2: Using Vite for Frontend Assets

In a separate terminal, run the Vite development server for hot module replacement:

```bash
npm run dev
```

Then access the application at: `http://127.0.0.1:8000`

#### Option 3: Build Frontend Assets for Production

To compile and minify assets for production:

```bash
npm run build
```

### Production Deployment

For production environments:

1. Set `APP_ENV=production` and `APP_DEBUG=false` in `.env`
2. Run `composer install --optimize-autoloader --no-dev`
3. Run `npm run build`
4. Run `php artisan config:cache`
5. Run `php artisan route:cache`
6. Run `php artisan view:cache`
7. Configure your web server (Apache/Nginx) to point to the `public` directory

---

## Default Credentials

Use these credentials to log in and test different role permissions:

| Role    | Email                  | Password   | Access Level                                    |
|---------|------------------------|------------|-------------------------------------------------|
| Admin   | `admin@example.com`    | `password` | Full system access (all modules, all actions)   |
| Manager | `manager@example.com`  | `password` | User, Section, and Class management (no role assignment) |
| User    | `user@example.com`     | `password` | Profile view/edit only                          |

---

## Architecture Overview

### RBAC Implementation via Spatie Laravel Permission

This application uses the [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission) package to implement a robust, scalable RBAC system.

#### Key Concepts

1. **Roles**: Collections of permissions (e.g., Admin, Manager, User)
2. **Permissions**: Granular actions (e.g., `users.view`, `sections.create`)
3. **Policies**: Laravel authorization gates for model-level checks
4. **Middleware**: Route-level protection (`RoleMiddleware`)

#### Permission Structure

Permissions follow a `resource.action` naming convention:

```
users.view
users.create
users.update
users.delete
users.assignRoles

sections.view
sections.create
sections.update
sections.delete

classes.view
classes.create
classes.update
classes.delete
```

#### Role Assignments

- **Admin**: All permissions (full system access)
- **Manager**: User, section, and class CRUD; cannot assign roles or manage permissions
- **User**: Profile view/update only

#### Middleware Protection

The `RoleMiddleware` enforces role-based route restrictions:
- Admin: Full access to all routes
- Manager: Access to user, section, and class management; blocked from role/permission routes
- User: Profile routes only

#### Policies

Authorization policies provide fine-grained control:
- `UserPolicy`: Controls user management actions
- `ProfilePolicy`: Controls profile access (users can only edit their own)
- `SectionPolicy`: Controls section management
- `ClassPolicy`: Controls class management

---

## Features

### 1. User Management
- **Admin**: Full CRUD operations, role assignment
- **Manager**: View, create, update, delete users (no role assignment)
- Server-side DataTables with search, sort, pagination
- Role-based action button visibility
- SweetAlert2 delete confirmations

### 2. Section Management
- **Admin/Manager**: Full CRUD operations
- Server-side DataTables integration
- Unique section names with validation
- Linked to Classes module

### 3. Class Management
- **Admin/Manager**: Full CRUD operations
- Select2 AJAX dropdown for section selection
  - Server-side search and pagination
  - Dynamic section loading
- Server-side DataTables with section filtering
- Foreign key relationship to sections

### 4. Profile Management
- All authenticated users can view/edit their own profile
- Password update functionality
- Account deletion with confirmation

### 5. Frontend Features
- **DataTables**: Server-side processing via Yajra package
- **Select2**: AJAX-powered dropdowns with search
- **SweetAlert2**: Beautiful confirmation dialogs and notifications
- **Responsive Design**: Tailwind CSS with mobile-first approach
- **RBAC Blade Directives**: `@can`, `@role`, `@cannot` for conditional rendering

---

## Testing

### Running Tests

Execute the test suite:

```bash
php artisan test
```

Or with detailed output:

```bash
php artisan test --parallel
```

### Test Coverage

The application includes:
- **Unit Tests**: Role assignment, permission checks, service logic
- **Feature Tests**: 
  - RBAC middleware restrictions
  - Policy authorization (e.g., Manager cannot assign roles)
  - CRUD workflows (create/update/delete success and validation failures)
  - Profile self-edit enforcement

### Test Database

Tests use an in-memory SQLite database by default. Configure `phpunit.xml` if you need a different setup.

---

## Project Structure

### Key Directories

```
rbac/
├── app/
│   ├── Http/
│   │   ├── Controllers/        # Resource controllers (User, Section, Class)
│   │   ├── Middleware/         # RoleMiddleware for route protection
│   │   └── Requests/           # Form request validation
│   ├── Models/                 # Eloquent models (User, Section, ClassModel)
│   ├── Policies/               # Authorization policies
│   └── Services/               # Business logic layer
├── database/
│   ├── migrations/             # Database schema migrations
│   ├── seeders/                # Database seeders (roles, permissions, users)
│   └── factories/              # Model factories for testing
├── resources/
│   ├── js/
│   │   ├── users/              # User module JS (DataTable, Select2, alerts)
│   │   ├── sections/           # Section module JS
│   │   └── classes/            # Class module JS (with Select2 AJAX)
│   ├── views/
│   │   ├── users/              # User CRUD views + partials
│   │   ├── sections/           # Section CRUD views + partials
│   │   └── classes/            # Class CRUD views + partials
│   └── css/
│       └── app.css             # Custom styles + DataTables CSS
├── routes/
│   └── web.php                 # Application routes
└── tests/
    ├── Feature/                # Feature tests (RBAC, CRUD)
    └── Unit/                   # Unit tests (services, policies)
```

### Technology Stack

- **Backend**: Laravel 12, PHP 8.2+
- **RBAC**: Spatie Laravel Permission
- **Frontend**: Tailwind CSS, Alpine.js
- **DataTables**: Yajra Laravel DataTables (server-side)
- **Select2**: AJAX-powered dropdowns
- **Alerts**: SweetAlert2
- **Build Tool**: Vite
- **Testing**: PHPUnit, Pest (optional)

---

## Additional Commands

### Clear All Caches

```bash
php artisan optimize:clear
```

### Generate IDE Helper Files (Development)

```bash
composer require --dev barryvdh/laravel-ide-helper
php artisan ide-helper:generate
php artisan ide-helper:models --nowrite
```

### Code Style Fixing (Laravel Pint)

```bash
./vendor/bin/pint
```

---

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

## Support

For issues, questions, or contributions, please contact the development team or open an issue in the project repository.

---

**Note**: This is a technical assignment project demonstrating RBAC implementation best practices in Laravel. All passwords are set to `password` for demonstration purposes only. In production, enforce strong password policies and use environment-specific credentials.
