# Postman Testing Guide

## 🚀 Quick Start

### Step 1: Start Laravel Server
```bash
php artisan serve
```
Server will run on: **http://localhost:8000**

### Step 2: Import Postman Collection
1. Open Postman
2. Click **Import** button (top left)
3. Select the file: `Laravel_User_API.postman_collection.json`
4. Collection will be imported with all endpoints

### Step 3: Set Base URL (if needed)
- The collection uses variable `{{base_url}}` = `http://localhost:8000`
- If your server runs on different port, update the variable:
  - Click on collection name → **Variables** tab
  - Update `base_url` value

---

## 📋 Testing Flow

### **1. Get Captcha First** ⚠️ IMPORTANT
**Endpoint:** `GET /api/auth/captcha`

**Why:** You need captcha for registration and login!

**Response Example:**
```json
{
    "captcha_key": "captcha_67890abcdef",
    "captcha_question": "5 + 3"
}
```

**Action:** 
- Copy the `captcha_key` 
- Solve the math question (e.g., 5 + 3 = 8)
- Use both in next requests

---

### **2. Register a New User**
**Endpoint:** `POST /api/auth/register`

**Body:**
```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "captcha_key": "captcha_67890abcdef",
    "captcha_answer": 8
}
```

**Expected Response (201):**
```json
{
    "message": "User registered successfully",
    "user": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "role": "user"
    },
    "token": "1|xxxxxxxxxxxxx"
}
```

**Save the token!** You'll need it for authenticated requests.

---

### **3. Login (Get Token)**
**Endpoint:** `POST /api/auth/login`

**Body:**
```json
{
    "email": "admin@example.com",
    "password": "password",
    "captcha_key": "captcha_67890abcdef",
    "captcha_answer": 8
}
```

**Default Test Accounts (after seeding):**
- **Admin:** `admin@example.com` / `password`
- **Manager:** `manager@example.com` / `password`
- **User:** `user@example.com` / `password`

**Expected Response (200):**
```json
{
    "message": "Login successful",
    "user": {
        "id": 1,
        "name": "Admin User",
        "email": "admin@example.com",
        "role": "admin"
    },
    "token": "2|yyyyyyyyyyyyy"
}
```

**Action:** Copy the token and add to Authorization header for next requests.

---

### **4. Set Authorization Token in Postman**

**Option A: Manual (Each Request)**
- Go to **Authorization** tab
- Type: **Bearer Token**
- Token: Paste your token

**Option B: Collection Variable (Automatic)**
- The collection has a variable `{{auth_token}}`
- After login, the token is automatically saved (if you use the collection)
- All requests use: `Bearer {{auth_token}}`

---

### **5. Test Authenticated Endpoints**

#### Get Current User
**Endpoint:** `GET /api/auth/user`
**Headers:** `Authorization: Bearer {token}`

#### Get Own Profile
**Endpoint:** `GET /api/user/profile`
**Headers:** `Authorization: Bearer {token}`

#### Update Own Profile
**Endpoint:** `PUT /api/user/profile`
**Headers:** `Authorization: Bearer {token}`
**Body:**
```json
{
    "name": "Updated Name",
    "email": "newemail@example.com"
}
```

---

### **6. Test Admin Endpoints** (Login as Admin First!)

#### List All Users (Paginated)
**Endpoint:** `GET /api/admin/users?per_page=15&page=1`
**Headers:** `Authorization: Bearer {admin_token}`

**Response:**
```json
{
    "data": [...users...],
    "meta": {
        "current_page": 1,
        "last_page": 667,
        "per_page": 15,
        "total": 10000
    }
}
```

#### Search Users
**Endpoint:** `GET /api/admin/users/search?search=john&per_page=15`
**Headers:** `Authorization: Bearer {admin_token}`

#### Get User by ID
**Endpoint:** `GET /api/admin/users/1`
**Headers:** `Authorization: Bearer {admin_token}`

#### Create User
**Endpoint:** `POST /api/admin/users`
**Headers:** `Authorization: Bearer {admin_token}`
**Body:**
```json
{
    "name": "New User",
    "email": "newuser@example.com",
    "password": "password123",
    "role": "user"
}
```

#### Update User
**Endpoint:** `PUT /api/admin/users/2`
**Headers:** `Authorization: Bearer {admin_token}`
**Body:**
```json
{
    "name": "Updated Name",
    "role": "manager"
}
```

#### Delete User
**Endpoint:** `DELETE /api/admin/users/2`
**Headers:** `Authorization: Bearer {admin_token}`

---

## 🔒 Important Notes

### Captcha
- **Always get captcha first** before register/login
- Captcha expires in 5 minutes
- Math questions: simple addition or multiplication (e.g., "5 + 3" or "4 * 2")

### Authentication
- All endpoints except `/api/auth/captcha`, `/api/auth/register`, `/api/auth/login` require token
- Add header: `Authorization: Bearer {token}`
- Token is valid until logout or expiration

### Rate Limiting
- Login endpoint: **5 attempts per minute**
- If you exceed, wait 1 minute before trying again

### Admin Access
- Admin endpoints require `role: admin`
- Login as `admin@example.com` to test admin features
- Regular users will get 403 Forbidden

### Pagination
- Default: 15 items per page
- Use `?per_page=50` to change
- Use `?page=2` for next page

---

## 🧪 Testing Checklist

- [ ] Get captcha
- [ ] Register new user
- [ ] Login with registered user
- [ ] Get current user info
- [ ] Get own profile
- [ ] Update own profile
- [ ] Login as admin
- [ ] List all users (with pagination)
- [ ] Search users
- [ ] Get user by ID
- [ ] Create new user (admin)
- [ ] Update user (admin)
- [ ] Delete user (admin)
- [ ] Logout
- [ ] Try accessing protected route without token (should fail)
- [ ] Try admin route as regular user (should fail)

---

## 🐛 Troubleshooting

### "Unauthenticated" Error
- Check if token is in Authorization header
- Format: `Bearer {token}` (with space after Bearer)
- Token might be expired, login again

### "Invalid captcha answer" Error
- Get a fresh captcha
- Make sure you're solving the math correctly
- Check captcha_key matches the one from captcha endpoint

### "403 Forbidden" on Admin Routes
- Make sure you're logged in as admin
- Check user role in login response
- Login with: `admin@example.com` / `password`

### "422 Validation Error"
- Check required fields are present
- Email must be valid format
- Password must be min 8 characters
- Password confirmation must match password

### Server Not Running
```bash
php artisan serve
```

### Database Not Seeded
```bash
php artisan db:seed
```

---

## 📝 Example Complete Flow

1. **Start server:** `php artisan serve`
2. **Get captcha:** `GET /api/auth/captcha` → Save key and answer
3. **Login as admin:** `POST /api/auth/login` → Save token
4. **List users:** `GET /api/admin/users` → See paginated results
5. **Search:** `GET /api/admin/users/search?search=admin`
6. **Create user:** `POST /api/admin/users` → New user created
7. **Update user:** `PUT /api/admin/users/2` → User updated
8. **Delete user:** `DELETE /api/admin/users/2` → User deleted
9. **Logout:** `POST /api/auth/logout` → Token invalidated

---

## 🎯 Quick Test Credentials

After running `php artisan db:seed`:

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@example.com | password |
| Manager | manager@example.com | password |
| User | user@example.com | password |

All users have password: **password**

