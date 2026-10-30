# 📚 Library Management System (Laravel 13)

> **PROJECT FINAL EXAM LARAVEL 13**  
> A complete, modern Library Management System built with **Laravel 13**, **Laravel Breeze (Blade)**, and **Tailwind CSS**.

---

## 🌟 Key Features & Requirements Checklist

- [x] **Requirement 1: Authentication System (Login & Register)**
  - Implemented using Laravel Breeze with Blade templates.
  - User registration, login session handling, remember me, logout, password reset, and profile management.
  - All library management routes protected with `auth` and `verified` middleware.
  
- [x] **Requirement 2: Relational Migrations & Eloquent Models**
  - **Categories Table** (`categories`): `id`, `name`, `description`, `timestamps`.
  - **Books Table** (`books`): `id`, `title`, `author`, `category_id` (foreign key constrained with cascading deletes), `stock`, `isbn`, `description`, `timestamps`.
  - **Eloquent Relationships**:
    - `Category` has many `Book` (`hasMany(Book::class)`).
    - `Book` belongs to `Category` (`belongsTo(Category::class)`).

- [x] **Requirement 3: Full CRUD Operations with Search & Multi-criteria Filtering**
  - **Book Cover Pictures**: Upload cover pictures with client-side live preview, automatic storage via `storage:link`, table thumbnails, and high-res view.
  - **Create**: Add books and categories with server-side validation.
  - **Read**: Browse catalog with stock indicators, pagination, and detailed book profile pages.
  - **Update**: Edit book and category metadata with pre-filled forms and image replacement.
  - **Delete**: Remove records with confirmation alerts, image cleanup, and flash notifications.
  - **Search**: Case-insensitive keyword search covering book **Title**, **Author**, and **ISBN**.
  - **Filters**: Dropdown filtering by **Category**, **Stock Availability** (In Stock / Out of Stock), and **Sorting** (Latest, Oldest, Title A-Z, Title Z-A, Highest Stock).

- [x] **Requirement 4: Git Version Control & GitHub Ready**
  - Clean repository with `.env`, `vendor/`, `node_modules/`, and SQLite cache properly ignored.

---

## 🏗️ Architecture & Development Flow

```mermaid
flowchart TD
    A[Visitor / Librarian] -->|Visits App| B{Authenticated?}
    B -->|No| C[Login / Register Page]
    B -->|Yes| D[Books Catalog Dashboard]
    
    C -->|Submits Credentials| E[Laravel Breeze Auth Controller]
    E -->|Valid| D
    
    D -->|Search Keyword| F[BookController@index]
    D -->|Filter Category / Stock| F
    D -->|Sort Order| F
    
    F -->|Eloquent Query with Eager Loading| G[(SQLite / MySQL Database)]
    G -->|Categories & Books| D
    
    D -->|Add New Book| H[BookController@create / store]
    D -->|Edit Book| I[BookController@edit / update]
    D -->|Delete Book| J[BookController@destroy]
    
    D -->|Manage Categories| K[CategoryController@index / store / update / destroy]
```

---

## 🚀 Quick Start Guide

### 1. Prerequisites
- **PHP** >= 8.2 (tested on PHP 8.5)
- **Composer** >= 2.x
- **Node.js** >= 18.x and **npm**

### 2. Installation
```bash
# Clone the repository
git clone <YOUR_GITHUB_REPOSITORY_URL>
cd finalnafi

# Install PHP dependencies
composer install

# Install Node dependencies and compile assets
npm install
npm run build

# Setup Environment file
cp .env.example .env
php artisan key:generate

# Run Migrations and Seed Sample Data
php artisan migrate --seed
```

### 3. Launch Development Server
```bash
php artisan serve
```
Open [http://127.0.0.1:8000](http://127.0.0.1:8000) in your web browser.

---

## 🔑 Pre-seeded Demo Credentials & Role Access

| Role | Email | Password | Permissions & Capabilities |
|---|---|---|---|
| **Admin (Librarian)** | `admin@library.com` | `password` | **Full CRUD**: Add books, edit books, delete books, manage categories, full statistics overview. |
| **User (Member)** | `user@library.com` | `password` | **Read & Search**: Browse catalog, search by keyword, filter by genre & stock availability, view details. Modifications restricted (403 Forbidden). |

*(New users registered via the **Register** form are assigned the standard `user` member role automatically.)*

---

## 🧪 Running Automated Tests

A comprehensive suite of feature and unit tests is included to verify all functionality:

```bash
php artisan test
```

Tests cover:
- Guest authentication redirects
- Book listing and details view
- Keyword search by title/author
- Category filter queries
- Book creation, update, and deletion
- Model relationship integrity (`hasMany` and `belongsTo`)

---

## 📦 Database Schema Details

### `categories` Table
| Column | Type | Attributes |
|---|---|---|
| `id` | BigIncrements | Primary Key |
| `name` | String | Required |
| `description` | Text | Nullable |
| `created_at` / `updated_at` | Timestamps | Automatic |

### `books` Table
| Column | Type | Attributes |
|---|---|---|
| `id` | BigIncrements | Primary Key |
| `title` | String | Required |
| `author` | String | Required |
| `category_id` | UnsignedBigInteger | Foreign Key (`categories.id`), `onDelete('cascade')` |
| `stock` | Integer | Default `0` |
| `isbn` | String | Nullable |
| `description` | Text | Nullable |
| `created_at` / `updated_at` | Timestamps | Automatic |

---

## 📤 How to Push to GitHub

1. Create a new repository on [GitHub](https://github.com/new) (e.g., `laravel-library-management-system`).
2. Run the following commands inside this directory:

```bash
git remote add origin https://github.com/<YOUR_GITHUB_USERNAME>/<YOUR_REPOSITORY_NAME>.git
git branch -M main
git push -u origin main
```
