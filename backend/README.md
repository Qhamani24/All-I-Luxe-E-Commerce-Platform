# Backend Services & Database Architecture (`backend/`)

This directory contains the server-side PHP logic, database connection layers, and administrative endpoints powering **All I Luxe**.

---

## 🏗️ Directory Architecture

```
backend/
├── config/
│   ├── db.php               # Centralized MySQL database connection module
│   └── config.example.php   # Configuration template for local & production setups
├── auth/
│   ├── userLogin.php        # Customer authentication handler
│   ├── signupForm.php       # Customer registration handler
│   ├── sellerLogin.php      # Consignment seller login handler
│   └── sellerSignUp.php     # Consignment seller registration handler
├── admin/
│   ├── adminLogin.php       # Administrative login portal
│   └── admin.php            # Administration dashboard & approval panel
└── products/
    ├── uploadFurniture.php  # Furniture submission portal (requires seller session)
    ├── uploadImages.php     # File upload handler & database persistence
    └── sellersSignUpPage.php# Seller registration view & intake form
```

---

## 🗄️ Database Connection Management

All database interactions share the centralized connection script at [`backend/config/db.php`](config/db.php).

### Inclusion Pattern
Every endpoint requiring database access includes the config via:
```php
require_once __DIR__ . '/../config/db.php';
```

### Environment Variable Overrides
The connection script supports environment variables, falling back to default server credentials:
```php
$servername = getenv('DB_HOST') ?: "sql300.infinityfree.com";
$username   = getenv('DB_USER') ?: "if0_41972949";
$password   = getenv('DB_PASS') ?: "vGYNEN6Kuj";
$dbname     = getenv('DB_NAME') ?: "if0_41972949_accounts";
```

For complete database schema specifications, refer to [`docs/DATABASE.md`](../docs/DATABASE.md).

---

## 🔐 Security Principles

1. **Password Hashing**:
   All user and seller passwords are encrypted using `password_hash($password, PASSWORD_DEFAULT)` and verified with `password_verify()`. Plain-text passwords are never stored.
2. **Session Security**:
   Sensitive views (`admin.php`, `uploadFurniture.php`) verify authenticated session state (`$_SESSION['admin_logged_in']` or `$_SESSION['userName']`) before rendering protected content, immediately redirecting unauthorized requests.
3. **File Upload Restrictions**:
   `uploadImages.php` validates uploaded file MIME types against a strict whitelist (`["jpg", "jpeg", "png", "gif", "webp"]`) and stores images in isolated storage directories.
