# Frontend Laravel Application Setup

This is a Bootstrap-based Laravel frontend that consumes REST APIs from the backend API server.

## Requirements

- PHP 8.1 or higher
- Composer
- MySQL 5.7 or higher
- Backend API running at `http://127.0.0.1:8000`

## Installation Steps

### 1. Install Dependencies

```bash
cd c:\xampp\htdocs\frontend
composer install
```

### 2. Environment Configuration

The `.env` file is already configured with:

```
BACKEND_URL=http://127.0.0.1:8000
APP_URL=http://localhost
SESSION_DRIVER=database
```

**Note:** Make sure your backend API is running on `http://127.0.0.1:8000`

### 3. Database Setup

The frontend uses the database for session storage:

```bash
php artisan migrate
```

### 4. Run the Application

Start the Laravel development server:

```bash
php artisan serve
```

The application will be available at: **http://localhost:8000** (or http://127.0.0.1:8000)

---

## Features

### Authentication
- **Login Page**: User login with email, password, and captcha
- **Register Page**: User registration with role selection and captcha
- **Session Management**: Token-based session stored in database
- **Logout**: Safely clear session

### Dashboard
- Welcome screen after login
- Display user information
- Quick links to profile and admin sections

### User Profile
- View and edit personal information
- Change password
- Display account details

### Admin Panel (Admin/Manager Only)
- **User Management**
  - List all users with pagination
  - Search users by name, email, or role
  - Create new users
  - Edit user information
  - Delete users
  - Role-based display (admin, manager, user)

---

## API Endpoints Used

The frontend consumes these backend API endpoints:

```
POST   /api/auth/captcha          - Get captcha question
POST   /api/auth/login             - User login
POST   /api/auth/register          - User registration
GET    /api/auth/user              - Get authenticated user
POST   /api/auth/logout            - Logout user

GET    /api/user/profile           - Get user profile
PUT    /api/user/profile           - Update user profile

GET    /api/admin/users            - List all users (paginated)
GET    /api/admin/users/search     - Search users
GET    /api/admin/users/{id}       - Get single user
POST   /api/admin/users            - Create user
PUT    /api/admin/users/{id}       - Update user
DELETE /api/admin/users/{id}       - Delete user
```

---

## Directory Structure

```
frontend/
├── app/
│   ├── Http/
│   │   ├── Controllers/Front/
│   │   │   ├── AuthController.php       - Authentication logic
│   │   │   ├── ProfileController.php    - Profile management
│   │   │   └── AdminUserController.php  - User management
│   │   └── Middleware/
│   │       └── FrontAuth.php            - Authentication middleware
│   └── Models/
├── resources/
│   └── views/
│       ├── auth/
│       │   ├── login.blade.php
│       │   └── register.blade.php
│       ├── layouts/
│       │   └── app.blade.php            - Main layout
│       ├── admin/users/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   └── edit.blade.php
│       ├── dashboard.blade.php
│       └── profile/
│           └── show.blade.php
└── routes/
    └── web.php                          - All routes
```

---

## Troubleshooting

### 1. "Cannot connect to backend API"

**Solution:**
- Ensure backend API is running: `php artisan serve` on port 8000
- Check `BACKEND_URL` in `.env` file
- Verify firewall isn't blocking connections

### 2. "Session expired" error

**Solution:**
- Clear browser cookies
- Clear Laravel cache: `php artisan cache:clear`
- Reset database: `php artisan migrate:refresh`

### 3. "Login/Register not working"

**Solution:**
- Check backend API endpoints are responding
- Verify captcha endpoint returns proper question
- Check Laravel logs: `storage/logs/laravel.log`

### 4. Admin pages not accessible

**Solution:**
- Ensure backend returns correct role in user response
- Check user role is 'admin' or 'manager'
- Verify token is valid on each request

---

## Authentication Flow

1. User visits `/login` or `/register`
2. Frontend requests captcha from backend API
3. User submits credentials + captcha answer
4. Backend validates and returns token + user data
5. Frontend stores token in session (database)
6. All subsequent requests include token in Authorization header
7. Protected routes checked by `FrontAuth` middleware
8. On logout, session is cleared

---

## Security Features

✅ CSRF Protection (Laravel built-in)
✅ Secure session storage (database)
✅ Token-based API authentication
✅ Input validation on all forms
✅ Error handling with user-friendly messages
✅ Session timeout (120 minutes default)
✅ Password fields never logged
✅ XSS protection (Blade escaping)

---

## Customization

### Change Session Timeout
Edit `.env`:
```
SESSION_LIFETIME=120
```

### Change Backend URL
Edit `.env`:
```
BACKEND_URL=http://your-api-domain.com
```

### Modify Bootstrap Theme
Edit `resources/views/layouts/app.blade.php` and update color schemes in the `<style>` section.

---

## Testing

### Test Login Flow
1. Register a new user at `/register`
2. Login at `/login`
3. Check dashboard appears
4. Visit profile page
5. Logout

### Test Admin Functions (if admin user)
1. Login as admin user
2. Navigate to Admin Users
3. Try creating/editing/deleting users
4. Test search functionality

---

## Support

For issues with the frontend, check:
- `storage/logs/laravel.log` for application errors
- Browser console (F12) for JavaScript errors
- Network tab to verify API calls

---

## Version History

- **v1.0** - Initial setup with auth, profile, and admin panel
- Built on Laravel 11
- Uses Bootstrap 5.3
- Token-based API authentication
