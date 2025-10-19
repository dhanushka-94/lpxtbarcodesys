# 🔐 Authentication System

## Overview
The barcode printing system now includes user authentication to track who prints barcodes and secure access to the system.

---

## 🚀 Quick Start

### Default Admin Account
```
Email: admin@msk.com
Password: password
```

⚠️ **Important:** Change the default password after first login!

---

## 🔑 Login Process

### Accessing the System
1. Go to: `http://localhost:8000`
2. You'll be automatically redirected to login page
3. Enter your email and password
4. Check "Remember me" to stay logged in (optional)
5. Click "Sign In"

### After Login
- You'll see your name in the top-right corner
- Access to all features (Search Products, Print Reports)
- All your prints will be logged with your name

### Logout
Click the "Logout" button in the top-right corner

---

## 👥 User Management

### Creating New Users

#### Method 1: Using Command (Recommended)
```bash
php artisan user:create
```

Follow the prompts:
- Enter user name (e.g., "John Doe")
- Enter email address (e.g., "john@msk.com")
- Enter password (min 8 characters)
- Confirm password

**Example:**
```
$ php artisan user:create

Create New User
==============

Enter user name:
> John Doe

Enter email address:
> john@msk.com

Enter password (min 8 characters):
> ********

Confirm password:
> ********

User created successfully!
+-------+--------------+
| Field | Value        |
+-------+--------------+
| Name  | John Doe     |
| Email | john@msk.com |
| ID    | 2            |
+-------+--------------+
```

#### Method 2: Using Database Seeder
Run the seeder to create default admin:
```bash
php artisan db:seed --class=AdminUserSeeder
```

#### Method 3: Manual Database Insert
```sql
INSERT INTO users (name, email, password, created_at, updated_at)
VALUES (
    'User Name',
    'user@msk.com',
    '$2y$12$[BCRYPT_HASH]',  -- Use Hash::make('password') in Laravel
    NOW(),
    NOW()
);
```

---

## 🔒 Security Features

### Password Requirements
- Minimum 8 characters
- Passwords are hashed using bcrypt
- Cannot be recovered (only reset)

### Session Management
- Sessions expire after inactivity
- "Remember me" option for 30 days
- Automatic logout on browser close (without remember me)

### Protected Routes
All system features require authentication:
- ✅ Search Products
- ✅ Generate Barcodes
- ✅ View Reports
- ✅ Export Reports

Only `/login` is accessible without authentication.

### CSRF Protection
All forms are protected against Cross-Site Request Forgery attacks.

---

## 📊 User Tracking

### What Gets Logged
Every barcode print now records:
- **Product details** (code, name, price)
- **Number of copies**
- **Timestamp** (date and time)
- **User who printed** (your name from account)

### Viewing Logs
1. Go to "Print Reports"
2. See "Printed By" column showing user names
3. Filter reports to see specific user's prints
4. Export CSV includes user information

---

## 🔧 Advanced Configuration

### Changing Default Credentials

#### Option 1: Via Database
```sql
UPDATE users 
SET email = 'newemail@msk.com',
    password = '$2y$12$NEW_HASH'
WHERE email = 'admin@msk.com';
```

#### Option 2: Via Tinker
```bash
php artisan tinker
```
```php
$user = User::where('email', 'admin@msk.com')->first();
$user->email = 'newemail@msk.com';
$user->password = Hash::make('newpassword');
$user->save();
```

### Session Configuration
Edit `.env` file:
```env
SESSION_DRIVER=database
SESSION_LIFETIME=120  # Minutes (default: 2 hours)
SESSION_ENCRYPT=false
```

### Adding More Users
Create as many users as you need:
```bash
php artisan user:create
```

Each user gets their own login credentials.

---

## 🎯 Use Cases

### Multiple Shop Staff
- Create account for each staff member
- Each person logs in with their own credentials
- Track who printed which barcodes
- Accountability for inventory management

### Manager Oversight
- View reports to see who's printing what
- Filter by date range to audit activity
- Export reports with user information
- Monitor staff productivity

### Security & Access Control
- Only authorized users can access system
- No anonymous barcode printing
- Complete audit trail
- Prevent unauthorized access

---

## 🐛 Troubleshooting

### Can't Login
**Problem:** Invalid credentials error

**Solutions:**
1. Check email is correct (admin@msk.com)
2. Ensure password is correct (password)
3. Check CAPS LOCK is off
4. Verify user exists in database:
   ```bash
   php artisan tinker
   User::where('email', 'admin@msk.com')->first();
   ```

### Session Expires Too Quickly
**Problem:** Logged out frequently

**Solution:**
1. Edit `.env`
2. Increase `SESSION_LIFETIME` (in minutes)
3. Enable "Remember me" when logging in

### Forgot Password
**Problem:** Can't remember password

**Solution:**
Reset via command line:
```bash
php artisan tinker
```
```php
$user = User::where('email', 'YOUR_EMAIL')->first();
$user->password = Hash::make('NEW_PASSWORD');
$user->save();
```

### Can't Create New User
**Problem:** Email already exists error

**Solution:**
1. Use different email address
2. Or delete existing user first:
   ```bash
   php artisan tinker
   User::where('email', 'email@msk.com')->delete();
   ```

---

## 📋 Technical Details

### Database Tables
- **users** - Stores user accounts
  - id, name, email, password
  - created_at, updated_at
  
- **sessions** - Stores user sessions
  - Handles "Remember me" functionality
  
- **barcode_print_logs** - Print history
  - Now includes `printed_by` field with user name

### Authentication Files
```
app/
  Http/Controllers/AuthController.php - Login/logout logic
  Console/Commands/CreateUser.php     - User creation command
resources/
  views/auth/login.blade.php          - Login page
routes/web.php                        - Protected routes
database/
  seeders/AdminUserSeeder.php         - Default admin user
```

### Middleware
- `auth` middleware protects all routes except login
- Automatically redirects to login if not authenticated
- Remembers intended URL after login

---

## 🔄 Updating Existing System

If you had the system before authentication was added:

1. **Migration Already Run:** Users table exists from Laravel installation
2. **Create Admin User:**
   ```bash
   php artisan db:seed --class=AdminUserSeeder
   ```
3. **Start Using:** Login with admin@msk.com / password
4. **Create Staff Accounts:** Use `php artisan user:create`

---

## 🎓 Best Practices

### For Administrators
1. ✅ Change default admin password immediately
2. ✅ Create separate accounts for each staff member
3. ✅ Use strong passwords (mix of letters, numbers, symbols)
4. ✅ Don't share passwords between users
5. ✅ Regularly review print logs

### For Users
1. ✅ Keep your password confidential
2. ✅ Logout when leaving the computer
3. ✅ Use "Remember me" only on trusted computers
4. ✅ Report suspicious activity to admin

### For Security
1. ✅ Change passwords every 90 days
2. ✅ Review user accounts periodically
3. ✅ Remove accounts for departed staff
4. ✅ Monitor print logs for anomalies
5. ✅ Keep Laravel and dependencies updated

---

## 📞 Support

**Default Admin Credentials:**
- Email: admin@msk.com
- Password: password

**Create New User:**
```bash
php artisan user:create
```

**Reset Password:**
```bash
php artisan tinker
$user = User::where('email', 'EMAIL')->first();
$user->password = Hash::make('NEW_PASSWORD');
$user->save();
```

**System Access:** http://localhost:8000

---

## ✅ Features Summary

- 🔐 Secure login system
- 👤 User tracking in print logs
- 🔒 Protected routes
- 💾 Session management
- 🔑 "Remember me" functionality
- 👥 Multi-user support
- 📊 User attribution in reports
- 🎨 Professional dark theme login page
- 🛠️ Easy user management commands
- 📝 Complete audit trail

