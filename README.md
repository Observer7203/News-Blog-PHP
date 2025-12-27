# Simple PHP Blog

A simple blog platform built with PHP 8.1+, MySQL, and Smarty template engine.

## Requirements

- Docker & Docker Compose
- OR PHP 8.1+, MySQL 8.0+, Composer

## Quick Start with Docker

1. Clone the repository and navigate to the project directory

2. Start the containers:
```bash
docker compose up -d --build
```

3. Install dependencies (if not installed during build):
```bash
docker compose exec php composer install
```

4. Run the seeder to populate test data:
```bash
docker compose exec php php database/seeds/seeder.php
```

5. Open http://localhost:8080 in your browser

## Manual Installation (without Docker)

1. Install dependencies:
```bash
composer install
```

2. Create MySQL database:
```sql
CREATE DATABASE blog CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

3. Run migrations:
```bash
mysql -u root -p blog < database/migrations/001_create_tables.sql
```

4. Configure environment variables (copy .env.example to .env and edit):
```bash
cp .env.example .env
```

5. Run the seeder:
```bash
php database/seeds/seeder.php
```

6. Start PHP development server:
```bash
php -S localhost:8080 -t public
```

## Project Structure

```
├── config/                 # Configuration files
│   ├── app.php
│   └── database.php
├── database/
│   ├── migrations/        # SQL migration files
│   └── seeds/             # Seeder scripts
├── docker/                # Docker configuration
│   ├── Dockerfile
│   └── nginx.conf
├── public/                # Web root
│   ├── index.php         # Entry point
│   └── assets/           # CSS, JS, images
├── src/
│   ├── Controllers/      # Controllers
│   ├── Core/             # Core classes (Router, Database, View)
│   └── Models/           # Models
├── templates/             # Smarty templates
│   ├── layouts/
│   ├── pages/
│   └── components/
├── docker-compose.yml
└── composer.json
```

## Features

- Homepage with categories and latest articles
- Category page with sorting and pagination
- Article page with related articles
- View counter for articles
- Responsive design (AbeloHost style)
- SCSS styling
- Admin panel with CRUD for categories and articles

## URLs

- `/` - Homepage
- `/category/{slug}` - Category page
- `/article/{slug}` - Article page

## Admin Panel

- `/admin` - Dashboard
- `/admin/categories` - Manage categories
- `/admin/articles` - Manage articles

**Credentials:**
- Login: `admin`
- Password: `admin123`

The admin panel includes a "Seed Database" button to populate test data.

## Database Schema

### Categories
- id (INT, PK)
- name (VARCHAR)
- slug (VARCHAR, UNIQUE)
- description (TEXT)
- created_at (TIMESTAMP)

### Articles
- id (INT, PK)
- title (VARCHAR)
- slug (VARCHAR, UNIQUE)
- description (TEXT)
- content (LONGTEXT)
- image (VARCHAR)
- views (INT)
- created_at (TIMESTAMP)

### Article-Category (Pivot)
- article_id (INT, FK)
- category_id (INT, FK)

## SCSS Compilation

If you want to modify styles, compile SCSS:

```bash
npm install -g sass
sass --watch public/assets/scss/style.scss:public/assets/css/style.css
```
