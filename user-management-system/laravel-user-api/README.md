# Laravel User Management API

<p align="center">
  <a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo"></a>
</p>

<p align="center">
  <strong>A comprehensive RESTful API for user management with authentication, role-based access control, and admin features built with Laravel 12</strong>
</p>

---

## 📋 Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Setup](#setup)
- [Configuration](#configuration)
- [Running the Application](#running-the-application)
- [API Endpoints](#api-endpoints)
- [Authentication](#authentication)
- [Usage Examples](#usage-examples)
- [Project Structure](#project-structure)
- [Database](#database)
- [Security Features](#security-features)
- [Testing](#testing)
- [Troubleshooting](#troubleshooting)
- [License](#license)

---

## 📖 Overview

This is a fully-featured RESTful API built with **Laravel 12** for managing users with secure authentication, role-based access control, and comprehensive admin functionality. The API uses **Laravel Sanctum** for token-based authentication and includes features like captcha verification, rate limiting, user search, and role-based permissions.

**Perfect for:** Building scalable user management systems with secure API endpoints.

---

## ✨ Features

### Authentication & Security
- ✅ User registration with math-based captcha verification
- ✅ User login with captcha and rate limiting (5 attempts/minute)
- ✅ Token-based authentication (Laravel Sanctum)
- ✅ Secure logout functionality
- ✅ Password hashing with bcrypt
- ✅ CSRF protection

### User Management
- ✅ User profile viewing and editing
- ✅ Change password functionality
- ✅ User account management

### Role-Based Access Control
- ✅ Three user roles: `admin`, `manager`, `user`
- ✅ Role-based middleware for protecting routes
- ✅ Admin-only operations protected

### Admin Capabilities
- ✅ List all users with pagination (15 items per page)
- ✅ View detailed user information
- ✅ Create new users
- ✅ Update user details and roles
- ✅ Delete users
- ✅ Search users by name, email, or role
- ✅ Change user roles dynamically

---

## 🔧 Requirements

Before installing, ensure you have:

- **PHP:** 8.2 or higher
- **Composer:** Latest version
- **Database:** SQLite (default) or MySQL/PostgreSQL
- **Node.js & npm:** For running frontend build tools (optional)
- **XAMPP** or **Laravel Sail** for local development

---

## 📦 Installation

### Step 1: Clone or Extract the Project

```bash
cd c:\xampp\htdocs\user-management-system\laravel-user-api
```

### Step 2: Install PHP Dependencies

```bash
composer install
```

This will install:
- Laravel Framework 12
- Laravel Sanctum (API authentication)
- Laravel Tinker (REPL)
- Testing tools (PHPUnit, Faker)

### Step 3: Install Node Dependencies (Optional)

If you want to use Vite for asset compilation:

```bash
npm install
```

---

## ⚙️ Setup

### Step 1: Create Environment File

Copy the example environment file:

```bash
copy .env.example .env
```

Or if using PowerShell:

```powershell
Copy-Item .env.example .env
```

### Step 2: Generate Application Key

```bash
php artisan key:generate
```

**Note:** This creates a unique encryption key for your application. The key will be added to `.env` as `APP_KEY`.

### Step 3: Configure Database (Optional)

By default, SQLite is configured. If you want to use MySQL, edit `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=user_management_api
DB_USERNAME=root
DB_PASSWORD=
```

Create the database:
```bash
mysql -u root -e "CREATE DATABASE user_management_api;"
```

### Step 4: Run Database Migrations

```bash
php artisan migrate
```

This creates:
- `users` table
- `cache` table
- `jobs` table
- `personal_access_tokens` table (for Sanctum)

### Step 5: (Optional) Seed Database with Test Data

```bash
php artisan db:seed
```

This creates:
- **Admin user:** `admin@example.com` / password: `password`
- **Manager user:** `manager@example.com` / password: `password`
- **Regular user:** `user@example.com` / password: `password`
- **10,000+ additional test users** for testing pagination and search

---

## 🔐 Configuration

### Environment Variables

Key configuration in `.env`:

```env
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:xxxxx (auto-generated)
APP_DEBUG=true
APP_URL=http://localhost:8000

SANCTUM_STATEFUL_DOMAINS=localhost

CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
```

### Sanctum Configuration

Edit `config/sanctum.php` to allow specific domains:

```php
'stateful' => explode(',', env('SANCTUM_STATEFUL_DOMAINS', 'localhost,localhost:3000,127.0.0.1,127.0.0.1:8000')),
```

---

## 🚀 Running the Application

### Option 1: PHP Built-in Server

```bash
php artisan serve
```

**Server runs on:** `http://localhost:8000`

To specify a different port:
```bash
php artisan serve --port=8001
```

### Option 2: XAMPP Apache

1. Enable Apache and MySQL in XAMPP Control Panel
2. Place project in `C:\xampp\htdocs\user-management-system\laravel-user-api`
3. Access via: `http://localhost/user-management-system/laravel-user-api/public`

### Option 3: Development Mode with Concurrent Services

```bash
composer run dev
```

This starts:
- PHP development server
- Queue listener
- Logs viewer (Pail)
- Vite development server

---

## 🔌 API Endpoints

### Authentication Routes (Public)

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/auth/captcha` | Get captcha for registration/login |
| POST | `/api/auth/register` | Register new user |
| POST | `/api/auth/login` | Login user and get token |

### Authenticated User Routes

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/auth/user` | Get current authenticated user |
| POST | `/api/auth/logout` | Logout user |
| GET | `/api/user/profile` | Get own profile |
| PUT | `/api/user/profile` | Update own profile |

### Admin Routes (Admin Only)

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/admin/users` | List all users (paginated) |
| GET | `/api/admin/users/search` | Search users by name/email/role |
| GET | `/api/admin/users/{id}` | Get specific user details |
| POST | `/api/admin/users` | Create new user |
| PUT | `/api/admin/users/{id}` | Update user |
| DELETE | `/api/admin/users/{id}` | Delete user |

---

## 🔑 Authentication

### Getting a Captcha

```http
GET /api/auth/captcha
```

**Response:**
```json
{
  "captcha_key": "captcha_1234567890",
  "captcha_question": "7 + 5"
}
```

### User Registration

```http
POST /api/auth/register
Content-Type: application/json

{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "securepassword123",
  "password_confirmation": "securepassword123",
  "captcha_key": "captcha_1234567890",
  "captcha_answer": 12
}
```

**Response:**
```json
{
  "message": "User registered successfully",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "role": "user",
    "created_at": "2025-11-16T10:30:00.000000Z"
  },
  "token": "1|H8Q4kL2mN9pR5tV7wX3yZ1aB9cD2eF4gH6iJ8kL0mN2"
}
```

### User Login

```http
POST /api/auth/login
Content-Type: application/json

{
  "email": "admin@example.com",
  "password": "password",
  "captcha_key": "captcha_1234567890",
  "captcha_answer": 12
}
```

**Response:**
```json
{
  "message": "Login successful",
  "user": {
    "id": 1,
    "name": "Admin User",
    "email": "admin@example.com",
    "role": "admin"
  },
  "token": "2|H8Q4kL2mN9pR5tV7wX3yZ1aB9cD2eF4gH6iJ8kL0mN2"
}
```

### Using the Token

Include the token in the `Authorization` header for authenticated requests:

```http
Authorization: Bearer 2|H8Q4kL2mN9pR5tV7wX3yZ1aB9cD2eF4gH6iJ8kL0mN2
```

---

## 📝 Usage Examples

### Example 1: Complete User Registration Flow

```bash
# 1. Get Captcha
curl -X GET http://localhost:8000/api/auth/captcha

# 2. Register User
curl -X POST http://localhost:8000/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Jane Smith",
    "email": "jane@example.com",
    "password": "Test@1234",
    "password_confirmation": "Test@1234",
    "captcha_key": "captcha_xxxxx",
    "captcha_answer": 12
  }'
```

### Example 2: Login and Access Protected Route

```bash
# 1. Login
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "jane@example.com",
    "password": "Test@1234",
    "captcha_key": "captcha_xxxxx",
    "captcha_answer": 12
  }'

# Save the returned token

# 2. Get Own Profile (using token)
curl -X GET http://localhost:8000/api/user/profile \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

### Example 3: Admin List Users

```bash
# Get all users with pagination
curl -X GET "http://localhost:8000/api/admin/users?per_page=10&page=1" \
  -H "Authorization: Bearer ADMIN_TOKEN_HERE"
```

**Response:**
```json
{
  "data": [
    {
      "id": 1,
      "name": "Admin User",
      "email": "admin@example.com",
      "role": "admin",
      "created_at": "2025-11-14T10:30:00.000000Z"
    },
    ...
  ],
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 100,
    "per_page": 10,
    "to": 10,
    "total": 10000
  }
}
```

### Example 4: Admin Search Users

```bash
curl -X GET "http://localhost:8000/api/admin/users/search?search=john&per_page=5" \
  -H "Authorization: Bearer ADMIN_TOKEN_HERE"
```

### Example 5: Admin Create New User

```bash
curl -X POST http://localhost:8000/api/admin/users \
  -H "Authorization: Bearer ADMIN_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "New Manager",
    "email": "manager_new@example.com",
    "password": "SecurePass123",
    "role": "manager"
  }'
```

### Example 6: Admin Update User Role

```bash
curl -X PUT http://localhost:8000/api/admin/users/2 \
  -H "Authorization: Bearer ADMIN_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Updated Name",
    "email": "newemail@example.com",
    "role": "admin"
  }'
```

### Example 7: Using Postman

A complete Postman collection is available: `Laravel_User_API.postman_collection.json`

Import it in Postman to test all endpoints with pre-configured requests.

---

## 📁 Project Structure

```
laravel-user-api/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── Api/
│   │   │       ├── Admin/
│   │   │       │   └── UserController.php         # Admin user management
│   │   │       ├── AuthController.php              # Authentication logic
│   │   │       └── UserController.php              # User profile management
│   │   ├── Middleware/
│   │   │   └── EnsureUserIsAdmin.php              # Admin access control
│   │   ├── Requests/
│   │   │   ├── Admin/
│   │   │   │   ├── CreateUserRequest.php
│   │   │   │   └── UpdateUserRequest.php
│   │   │   ├── LoginRequest.php
│   │   │   ├── RegisterRequest.php
│   │   │   └── UpdateProfileRequest.php
│   │   └── Resources/
│   │       └── UserResource.php                   # JSON response formatting
│   ├── Models/
│   │   └── User.php                               # User model with roles
│   └── Services/
│       └── CaptchaService.php                     # Captcha generation
├── database/
│   ├── factories/
│   │   └── UserFactory.php                        # Test data generation
│   ├── migrations/
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 0001_01_01_000001_create_cache_table.php
│   │   ├── 0001_01_01_000002_create_jobs_table.php
│   │   ├── 2025_11_14_054852_create_personal_access_tokens_table.php
│   │   └── 2025_11_14_055122_add_role_to_users_table.php
│   └── seeders/
│       └── DatabaseSeeder.php                     # Database seed data
├── routes/
│   ├── api.php                                    # API route definitions
│   ├── web.php
│   └── console.php
├── config/
│   ├── app.php
│   ├── auth.php
│   ├── database.php
│   ├── sanctum.php                                # Sanctum configuration
│   └── [other configs]
├── bootstrap/
│   ├── app.php                                    # Application bootstrap
│   └── providers.php
├── tests/
│   ├── Feature/                                   # Feature tests
│   └── Unit/                                      # Unit tests
├── storage/
│   ├── app/
│   ├── logs/
│   └── framework/
├── .env.example                                   # Example environment file
├── composer.json                                  # PHP dependencies
├── package.json                                   # Node dependencies
├── artisan                                        # Laravel CLI
└── README.md                                      # This file
```

---

## 🗄️ Database

### Database Tables

#### Users Table
```sql
CREATE TABLE users (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) UNIQUE NOT NULL,
  email_verified_at TIMESTAMP NULL,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin', 'manager', 'user') DEFAULT 'user',
  remember_token VARCHAR(100) NULL,
  created_at TIMESTAMP,
  updated_at TIMESTAMP
);
```

#### Personal Access Tokens Table (Sanctum)
```sql
CREATE TABLE personal_access_tokens (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  tokenable_type VARCHAR(255) NOT NULL,
  tokenable_id BIGINT NOT NULL,
  name VARCHAR(255) NOT NULL,
  token VARCHAR(64) UNIQUE NOT NULL,
  abilities JSON NULL,
  last_used_at TIMESTAMP NULL,
  expires_at TIMESTAMP NULL,
  created_at TIMESTAMP,
  updated_at TIMESTAMP
);
```

### Viewing Database

#### SQLite (Default)
- File location: `database/database.sqlite`
- Can be opened with SQLite viewers

#### MySQL
```bash
mysql -u root -p user_management_api
```

### Migration Management

```bash
# Show migration status
php artisan migrate:status

# Rollback last migration
php artisan migrate:rollback

# Rollback all migrations
php artisan migrate:reset

# Refresh (rollback + migrate)
php artisan migrate:refresh

# Refresh and seed
php artisan migrate:refresh --seed
```

---

## 🔒 Security Features

### 1. **Password Hashing**
- All passwords are hashed with bcrypt
- Password field is hidden in API responses

### 2. **Captcha Verification**
- Math-based captcha on registration and login
- Prevents automated abuse

### 3. **Rate Limiting**
- Login endpoint: 5 attempts per minute
- Configuration in `app/Http/Middleware`

### 4. **Token-Based Authentication**
- Laravel Sanctum for API tokens
- Tokens are unique and cannot be reused after logout
- Token stored in database for validation

### 5. **Role-Based Access Control**
- Admin middleware (`EnsureUserIsAdmin::class`)
- Routes protected based on user role
- Three predefined roles: admin, manager, user

### 6. **CSRF Protection**
- Built into Laravel (optional for API routes)

### 7. **Input Validation**
- All inputs validated through Form Request classes
- Database injection protection via parameterized queries

### 8. **Hidden Sensitive Data**
- Passwords hidden from JSON responses
- Remember tokens not exposed

---

## 🧪 Testing

### Running Tests

```bash
php artisan test
```

This runs:
- Feature tests in `tests/Feature/`
- Unit tests in `tests/Unit/`

### Running Specific Test

```bash
php artisan test tests/Feature/ExampleTest.php
```

### Creating a New Test

```bash
php artisan make:test MyNewTest --feature
```

### Testing API Endpoints with Postman

1. Import `Laravel_User_API.postman_collection.json` in Postman
2. Set up environment variables (base URL, token)
3. Run individual requests or full collections
4. See testing guide in `POSTMAN_TESTING_GUIDE.md`

---

## 🔧 Troubleshooting

### Issue: "No application encryption key has been specified"

**Solution:**
```bash
php artisan key:generate
```

### Issue: Database connection fails

**Solution:** Check `.env` file for correct database credentials:
```bash
# For SQLite
DB_DATABASE=database/database.sqlite

# For MySQL
DB_HOST=127.0.0.1
DB_DATABASE=user_management_api
DB_USERNAME=root
DB_PASSWORD=your_password
```

### Issue: CORS errors when calling from frontend

**Solution:** Configure CORS in `config/cors.php` or add CORS middleware:

```php
'allowed_origins' => ['http://localhost:3000', 'http://localhost:5173'],
```

### Issue: Token expires or is invalid

**Solution:** Generate a new token by logging in again:
```bash
POST /api/auth/login
```

### Issue: "User is not an admin" error

**Solution:** Ensure the user has admin role. Login as admin user:
```json
{
  "email": "admin@example.com",
  "password": "password"
}
```

### Issue: Port 8000 already in use

**Solution:** Use a different port:
```bash
php artisan serve --port=8001
```

### Issue: Composer install fails

**Solution:** Clear composer cache:
```bash
composer clear-cache
composer install
```

---

## 📚 Useful Commands

```bash
# Clear all caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Generate new application key
php artisan key:generate

# List all API routes
php artisan route:list --path=api

# Create new controller
php artisan make:controller Api/MyController --api

# Create new model with migration
php artisan make:model MyModel -m

# Create new migration
php artisan make:migration create_my_table

# Create new seeder
php artisan make:seeder MySeeder

# Create new form request
php artisan make:request MyRequest

# Interactive shell (Laravel Tinker)
php artisan tinker
```

---

## 📄 License

This project is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
