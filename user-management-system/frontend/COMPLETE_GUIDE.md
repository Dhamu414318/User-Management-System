# 🚀 Complete Frontend Setup & Running Guide

## System Requirements

- ✅ PHP 8.1+ (Laravel 11 requirement)
- ✅ MySQL 5.7+ 
- ✅ Composer
- ✅ 100MB free disk space
- ✅ Backend API at `http://127.0.0.1:8000`

---

## Step 1: Initial Setup

### Option A: Automatic Setup (Windows)

Double-click `setup.bat` in the frontend folder:
```cmd
c:\xampp\htdocs\frontend\setup.bat
```

This runs:
- ✓ composer install
- ✓ cache:clear
- ✓ migrate (database setup)
- ✓ key:generate (if needed)

### Option B: Manual Setup

```cmd
cd c:\xampp\htdocs\frontend

# 1. Install dependencies
composer install

# 2. Clear cache
php artisan cache:clear

# 3. Setup database
php artisan migrate

# 4. Generate key (if first time)
php artisan key:generate
```

---

## Step 2: Verify Configuration

Check `.env` file contains:

```env
BACKEND_URL=http://127.0.0.1:8000
APP_URL=http://localhost
APP_ENV=local
APP_DEBUG=true
SESSION_DRIVER=database
SESSION_LIFETIME=120
```

**Important:** Backend API must be running first!

---

## Step 3: Start the Frontend Server

```cmd
cd c:\xampp\htdocs\frontend
php artisan serve
```

Output should show:
```
Starting Laravel development server: http://127.0.0.1:8000

[INFO] Listening on http://127.0.0.1:8000
Press Ctrl+C to quit
```

---

## Step 4: Access the Application

Open browser and visit: **http://localhost:8000**

You should see the welcome page with "Log in" and "Register" links.

---

## 📱 Complete User Flow

### 1️⃣ Registration
```
http://localhost:8000/register
↓
Fill form:
  - Name: John Doe
  - Email: john@example.com
  - Password: SecurePass123
  - Role: User (or Manager/Admin)
  - Captcha: Answer the math question
↓
Click "Register"
↓
See success message
↓
Redirected to login
```

### 2️⃣ Login
```
http://localhost:8000/login
↓
Fill form:
  - Email: john@example.com
  - Password: SecurePass123
  - Captcha: Answer the question
↓
Click "Login"
↓
See dashboard
```

### 3️⃣ Dashboard
```
Dashboard page shows:
  - Welcome message with your name
  - Your email
  - Your role
  - "View Profile" button
  - "Manage Users" button (if admin)
```

### 4️⃣ Profile Management
```
Click "Profile" in navbar
↓
Update:
  - Name: Can change
  - Email: Can change
  - Password: Leave blank to keep current
  - Role: Read-only
↓
Click "Save Changes"
↓
Back to profile with success message
```

### 5️⃣ Admin User Management (Admin Only)
```
Click "Admin Users" in navbar
↓
See all users in table with:
  - ID
  - Name
  - Email
  - Role (with colored badge)
  - Action buttons

Features:
  ✓ Pagination (if many users)
  ✓ Search by name/email/role
  ✓ Edit user details
  ✓ Delete user (with confirmation)
  ✓ Create new user
```

### 6️⃣ Logout
```
Click "Logout" button
↓
Session cleared
↓
Redirected to login
↓
Success message shown
```

---

## 🔍 Testing the Complete System

### Quick Test (5 minutes)

1. **Start Backend API**
   ```cmd
   cd c:\xampp\htdocs\backend
   php artisan serve
   ```

2. **Start Frontend**
   ```cmd
   cd c:\xampp\htdocs\frontend
   php artisan serve
   ```

3. **Register User** → Visit `/register`
4. **Login** → Visit `/login` with new credentials
5. **View Dashboard** → Should see welcome message
6. **Test Admin** → Create admin user, manage users

### Full Test (30 minutes)

Follow the **Complete User Flow** above completely, testing:
- ✅ Form validation
- ✅ Error messages
- ✅ Success messages
- ✅ Navigation
- ✅ All features

---

## 📋 Project Structure

```
frontend/
│
├── app/Http/Controllers/Front/
│   ├── AuthController.php          ← Login/Register/Logout
│   ├── ProfileController.php       ← Profile CRUD
│   └── AdminUserController.php     ← User Management
│
├── app/Http/Middleware/
│   └── FrontAuth.php               ← Protect routes
│
├── resources/views/
│   ├── layouts/app.blade.php       ← Main template
│   ├── auth/
│   │   ├── login.blade.php
│   │   └── register.blade.php
│   ├── admin/users/
│   │   ├── index.blade.php         ← User list
│   │   ├── create.blade.php        ← Create form
│   │   └── edit.blade.php          ← Edit form
│   ├── dashboard.blade.php
│   └── profile/show.blade.php
│
├── routes/
│   └── web.php                     ← All routes
│
├── .env                            ← Configuration
├── setup.bat                       ← Quick setup
├── SETUP.md                        ← Full setup guide
├── QUICKREF.md                     ← Quick reference
└── TESTING_CHECKLIST.md            ← Testing guide
```

---

## 🔐 Routes Map

| Route | Method | Auth | Purpose |
|-------|--------|------|---------|
| `/` | GET | No | Welcome page |
| `/login` | GET | No | Login form |
| `/login` | POST | No | Process login |
| `/register` | GET | No | Register form |
| `/register` | POST | No | Process registration |
| `/dashboard` | GET | Yes | User dashboard |
| `/profile` | GET | Yes | View profile |
| `/profile` | POST | Yes | Update profile |
| `/logout` | POST | Yes | Logout user |
| `/admin/users` | GET | Yes* | List users |
| `/admin/users/search` | GET | Yes* | Search users |
| `/admin/users/create` | GET | Yes* | Create form |
| `/admin/users` | POST | Yes* | Store user |
| `/admin/users/{id}/edit` | GET | Yes* | Edit form |
| `/admin/users/{id}` | POST | Yes* | Update user |
| `/admin/users/{id}/delete` | POST | Yes* | Delete user |

*Admin/Manager only

---

## 🛠️ Useful Commands

```cmd
# Clear cache
php artisan cache:clear

# Check routes
php artisan route:list

# Fresh migrations
php artisan migrate:refresh

# See logs
tail -f storage/logs/laravel.log

# Database query
php artisan tinker
>>> DB::table('sessions')->count()
>>> exit

# Clear sessions
php artisan tinker
>>> DB::table('sessions')->truncate()
>>> exit
```

---

## ❌ Common Issues & Fixes

### Issue: "Cannot connect to backend API"
```
❌ Problem: Shows error when logging in
✅ Solution: 
   1. Start backend: php artisan serve (in backend folder on port 8000)
   2. Check .env has: BACKEND_URL=http://127.0.0.1:8000
   3. Try again
```

### Issue: "SQLSTATE[HY000]: General error: 1030"
```
❌ Problem: Database error
✅ Solution:
   php artisan migrate
   php artisan cache:clear
```

### Issue: "419 Page Expired"
```
❌ Problem: CSRF token issue
✅ Solution:
   1. Clear browser cookies
   2. Clear Laravel cache: php artisan cache:clear
   3. Try again
```

### Issue: "Class not found" errors
```
❌ Problem: Autoloader issue
✅ Solution:
   composer install
   php artisan cache:clear
```

### Issue: "Login page shows blank/errors"
```
❌ Problem: Captcha endpoint not working
✅ Solution:
   1. Verify backend API running
   2. Test API: curl http://127.0.0.1:8000/api/auth/captcha
   3. Check backend logs
```

### Issue: "Session expired" after login
```
❌ Problem: Token not stored properly
✅ Solution:
   1. Check SESSION_DRIVER=database in .env
   2. Run migrations: php artisan migrate
   3. Clear sessions: php artisan tinker → DB::table('sessions')->truncate()
```

---

## 📊 Expected Behavior

### Successful Flow
```
Register → Login → Dashboard → Admin Users → Logout
✓ Each step works smoothly
✓ Messages are clear
✓ Redirects happen automatically
```

### Error Handling
```
Invalid credentials → "Invalid email/password"
Backend down → "Cannot connect to backend API"
Session expired → "Session expired. Please log in again."
Permission denied → Redirect to dashboard
Invalid input → "Field is required" / "Invalid email"
```

---

## 🎯 Next Steps After Setup

1. ✅ **Verify all tests pass** (see TESTING_CHECKLIST.md)
2. ✅ **Create test admin user**
3. ✅ **Test all admin functions**
4. ✅ **Verify pagination works**
5. ✅ **Test search functionality**
6. ✅ **Record video walkthrough** (for submission)

---

## 📞 Getting Help

### Check Logs
```cmd
# Real-time logs
tail -f storage/logs/laravel.log

# Windows - view file
notepad storage/logs/laravel.log
```

### Debug Mode
```env
# In .env
APP_DEBUG=true    # Shows detailed errors
LOG_LEVEL=debug   # Logs everything
```

### Network Inspection
```
1. Open browser F12
2. Go to Network tab
3. Try to login
4. See actual API requests and responses
5. Check if requests reach backend
```

### Database Inspection
```cmd
php artisan tinker
>>> DB::table('sessions')->first()
>>> DB::table('users')->count()
>>> exit
```

---

## ✨ Success Indicators

After setup, you should see:

- ✅ Welcome page loads
- ✅ Can register new user
- ✅ Can login with registered account
- ✅ Dashboard shows user info
- ✅ Profile page works
- ✅ Can logout successfully
- ✅ Admin can manage users
- ✅ Search functionality works
- ✅ Pagination works
- ✅ No errors in browser console

---

## 🎥 Recording Video Walkthrough

When recording your video, demonstrate:

1. **Registration** (30 seconds)
   - Open register page
   - Fill form
   - Submit with captcha

2. **Login** (30 seconds)
   - Open login
   - Submit credentials
   - See dashboard

3. **User Operations** (2 minutes)
   - View profile
   - Edit profile
   - Change password
   - Logout

4. **Admin Operations** (3 minutes)
   - Login as admin
   - List users
   - Search users
   - Create new user
   - Edit user
   - Delete user
   - Show pagination

5. **Responsive Design** (1 minute)
   - Show mobile view
   - Show tablet view
   - Show desktop

**Total Duration:** ~7-10 minutes

---

## 📝 Documentation Files

- **SETUP.md** - Complete setup instructions
- **QUICKREF.md** - Quick reference guide
- **TESTING_CHECKLIST.md** - Test all features
- **This file** - Complete running guide

---

## 🎉 You're Ready!

Your frontend application is now:
- ✅ Fully configured
- ✅ Connected to backend
- ✅ Ready for production
- ✅ Tested and verified

**Enjoy building! 🚀**

---

**Version:** 1.0  
**Last Updated:** November 2024  
**Status:** Production Ready
