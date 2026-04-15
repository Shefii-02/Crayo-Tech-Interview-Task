
# 🚀 LARAVEL + WORDPRESS SENIOR PRACTICAL ASSESSMENT TEST



# 📌 Project Overview

This project is a **full-stack system** built using:

* **Laravel (Backend)**
* **WordPress (Frontend CMS Integration)**

It allows admins to:

* Create dynamic forms
* Collect submissions
* Import & export data
* Provide API for external systems (WordPress)

---

# 🧱 Tech Stack

## Backend

* PHP 8+
* Laravel (Latest)
* MySQL
* Laravel Breeze (Auth)

## Frontend

* WordPress CMS
* Custom Plugin
* REST API Integration

---

# 🔐 Admin Credentials

```text
Email: admin@test.com
Password: password123
```

---

# ⚙️ Laravel Setup

## 📥 Installation

```bash
git clone <your-repo-url>
cd form-system

composer install
cp .env.example .env
php artisan key:generate
```

---

## 🗄️ Database Setup

```bash
php artisan migrate
php artisan db:seed
```

---

## ▶️ Run Project

```bash
php artisan serve
```

Open:

```text
http://127.0.0.1:8000
```

---

# 🧩 Laravel Features

## ✅ Authentication & Roles

* Admin / User roles
* Login / Register / Logout

## ✅ Admin Panel

Routes:

```text
/admin/dashboard
/admin/forms
/admin/users
/admin/submissions
/admin/import
/admin/export
```

---

## ✅ Dynamic Form Builder

* Default Fields: Name, Email, Phone
* Custom Fields:

  * Text
  * Number
  * Email
  * Date
  * Dropdown
  * Checkbox
* Validation rules supported

---

## ✅ Dynamic Validation Engine

* Required validation
* Email validation
* Numeric validation
* Custom rules (min/max)

---

## ✅ Submission Management

* View submissions
* Filter by form
* Delete submissions
* Pagination enabled

---

## ✅ Import System (CSV)

* Upload CSV
* Preview valid & invalid rows
* Import only valid data

---

## ✅ Export System

* Export submissions to CSV
* Filter by form

---

## 🌐 REST API

### Endpoint:

```text
GET /api/users
```

### Features:

* Pagination
* Limit support
* Structured JSON response

### Example:

```text
/api/users?limit=5&page=1
```

---

## 📦 API Response Format

```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "John",
      "email": "john@test.com"
    }
  ],
  "meta": {
    "current_page": 1,
    "last_page": 2,
    "per_page": 10,
    "total": 20
  }
}
```

---

# 🌍 Public Form

```text
/form/{id}
```

* Dynamic form rendering
* Submission storage
* Validation applied

---

# 🧩 WordPress Setup

## 📥 Installation

1. Install WordPress (XAMPP/MAMP)
2. Create database
3. Complete setup

---

## 🔌 Plugin Setup

Path:

```text
wp-content/plugins/laravel-api-users/
```

File:

```text
laravel-api-users.php
```

Activate plugin from WordPress admin.

---

## 🔗 API Connection

Update API URL in plugin:

```php
return "http://127.0.0.1:8000/api/users";
```

---

## 📄 Pages

### 🟢 Home Page

```text
[laravel_users_slider]
```

### 🔵 Users Page

```text
[laravel_all_users]
```

---

## 🎯 Features

### ✅ Slider

* Displays latest 10 users
* Horizontal scroll layout

### ✅ Users Page

* Paginated list
* Dynamic API data

---

# 🧪 Testing

## API Test

```text
http://127.0.0.1:8000/api/users
```

## WordPress Test

* Homepage → Slider
* Users page → Pagination

---

# 📸 Screenshots (Add These)

## Laravel

1. Login Page
2. Admin Dashboard
3. Form Builder
4. Form Fields Creation
5. Submissions Page
6. Import Preview
7. Export Page
8. Public Form Page

## WordPress

1. Homepage Slider
2. Users Page
3. Pagination
4. Plugin Activation Page

---

# 🙌 Thank You

