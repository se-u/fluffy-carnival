# Poliklinik App

Aplikasi sistem manajemen poliklinik berbasis web dengan Laravel 11.

## Requirements

- PHP 8.2+
- Composer
- Node.js 18+
- MySQL 8.0+

## Cara Menjalankan

### 1. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### 2. Setup Environment

```bash
# Copy .env file
cp .env.example .env

# Generate application key
php artisan key:generate

# Run migrations
php artisan migrate

# Seed database 
php artisan db:seed
```

### 3. Jalankan Server (Buka di terminal berbeda)

**Terminal 1 - Laravel Server:**
```bash
php artisan serve --host=0.0.0.0 --port=8001
```

**Terminal 2 - Laravel Reverb (WebSocket):**
```bash
php artisan reverb:start --host=0.0.0.0 --port=8090
```

**Terminal 3 - Vite (Hot Reload):**
```bash
npm run dev
```

### 4. Akses Aplikasi

- **Aplikasi:** http://localhost:8001

## Default Login

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@poliklinik.com | password |
| Dokter | dokter@poliklinik.com | password |
| Pasien | pasien@poliklinik.com | password |

## Build for Production

```bash
npm run build
```

## Troubleshooting


### Storage link not found
```bash
php artisan storage:link
```
