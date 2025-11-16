# Frontend - Quick Reference Guide

## 🚀 Quick Start (Windows)

```cmd
cd c:\xampp\htdocs\frontend
setup.bat
```

This will:
1. Install all dependencies
2. Clear cache
3. Run migrations
4. Setup database

Then start the server:
```cmd
php artisan serve
```

Visit: **http://localhost:8000**

---

## 📋 File Structure

| Path | Purpose |
|------|---------|
| `app/Http/Controllers/Front/AuthController.php` | Login/Register/Logout logic |
| `app/Http/Controllers/Front/ProfileController.php` | User profile management |
| `app/Http/Controllers/Front/AdminUserController.php` | Admin user CRUD operations |
| `app/Http/Middleware/FrontAuth.php` | Authentication middleware |
| `resources/views/auth/` | Login/Register pages |
| `resources/views/layouts/app.blade.php` | Main layout template |
| `resources/views/admin/users/` | Admin user management pages |
| `routes/web.php` | All application routes |

---

## 🔐 Routes Overview

### Public Routes
```
GET  /                    → Welcome page
GET  /login               → Login form
POST /login               → Process login
GET  /register            → Registration form
POST /register            → Process registration
```

### Protected Routes (Requires Login)
```
GET  /dashboard           → User dashboard
POST /logout              → Logout user
GET  /profile             → View profile
POST /profile             → Update profile

GET  /admin/users         → List all users (admin only)
GET  /admin/users/search  → Search users
GET  /admin/users/create  → Create user form
POST /admin/users         → Store new user
GET  /admin/users/{id}/edit → Edit user form
POST /admin/users/{id}    → Update user
POST /admin/users/{id}/delete → Delete user
```

---

## 🔌 API Integration

All API calls go through these controllers:

### AuthController
- Gets captcha from `/api/auth/captcha`
- Sends login to `/api/auth/login`
- Sends register to `/api/auth/register`
- Verifies user with `/api/auth/user`
- Sends logout to `/api/auth/logout`

### ProfileController
- Fetches profile from `/api/user/profile`
- Updates profile to `/api/user/profile`

### AdminUserController
- Lists users from `/api/admin/users`
- Searches users at `/api/admin/users/search`
- Gets single user from `/api/admin/users/{id}`
- Creates user at `/api/admin/users`
- Updates user at `/api/admin/users/{id}`
- Deletes user at `/api/admin/users/{id}`

---

## 🛠️ Common Tasks

### Test the Application

1. **Register a new user:**
   - Go to `http://localhost:8000/register`
   - Fill in form and submit

2. **Login:**
   - Go to `http://localhost:8000/login`
   - Use registered credentials

3. **Test Admin Functions (if admin user):**
   - Click "Admin Users" in navbar
   - Try Create, Edit, Delete, Search

### Clear Sessions
```cmd
php artisan tinker
>>> DB::table('sessions')->truncate();
>>> exit
```

### Check Database
```cmd
php artisan tinker
>>> DB::table('sessions')->count();
```

### View Logs
```cmd
tail -f storage/logs/laravel.log
```

---

## ❌ Troubleshooting

| Problem | Solution |
|---------|----------|
| "Cannot connect to backend" | Ensure backend runs at `http://127.0.0.1:8000` |
| "Invalid token" | Clear sessions: `php artisan tinker` → `DB::table('sessions')->truncate()` |
| "Login page blank" | Check backend captcha endpoint: `curl http://127.0.0.1:8000/api/auth/captcha` |
| "Database error" | Run migrations: `php artisan migrate` |
| "404 Not Found" | Clear cache: `php artisan cache:clear` and `php artisan route:cache` |
| "CSRF token mismatch" | Make sure forms include `@csrf` |
| "Session storage issues" | Check `SESSION_DRIVER=database` in `.env` |

---

## 📝 Environment Variables

Key settings in `.env`:

```
BACKEND_URL=http://127.0.0.1:8000      # Backend API URL
APP_URL=http://localhost                # Frontend URL
SESSION_DRIVER=database                 # Store sessions in DB
SESSION_LIFETIME=120                    # 120 minutes session timeout
DB_DATABASE=laravel                     # Database name
DB_USERNAME=root                        # Database user
DB_PASSWORD=                            # Database password
```

---

## 🎨 Styling

The application uses **Bootstrap 5.3** with custom gradient:
- Purple gradient background
- Responsive design
- Mobile-friendly forms
- Professional UI

Colors:
- Primary: #667eea (purple)
- Secondary: #764ba2 (darker purple)
- Success: #48bb78 (green)

---

## 🔑 Authentication

Session flow:
1. User submits login/register
2. Frontend sends to backend API
3. Backend validates and returns token
4. Frontend stores token in session (database)
5. All API calls include token
6. Middleware checks token validity
7. On logout, session cleared

---

## 📦 Dependencies

Main Composer packages:
- `laravel/framework` - Web framework
- `guzzlehttp/guzzle` - HTTP client for API calls
- `symfony/http-client` - HTTP support

---

## 🧪 Testing

### Test Register → Login → Admin Flow

```
1. Visit http://localhost:8000/register
2. Fill form with admin role
3. Login with credentials
4. Go to /admin/users
5. Create/Edit/Delete users
6. Logout
```

### Test Error Handling

```
1. Stop backend API
2. Try to login
3. Should show: "Cannot connect to backend API"
4. Restart backend API
5. Try again - should work
```

---

## 📞 Support

Check logs in: `storage/logs/laravel.log`

Browser console (F12) for JavaScript errors

Network tab to see API requests

---

**Last Updated:** November 2024
