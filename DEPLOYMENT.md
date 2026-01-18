# Deployment Guide

## Option 1: Clever Cloud (Recommended)

### Prerequisites
- Clever Cloud account at [clever-cloud.com](https://clever-cloud.com)
- GitHub account connected to Clever Cloud

### Step 1: Create PHP Application
1. Go to Clever Cloud Dashboard → **Create App**
2. Select **PHP** runtime
3. Choose your GitHub repository `AnyX0/portofolio-web`
4. Select `main` branch
5. Leave build environment blank (auto-detected)

### Step 2: Add MySQL Database
1. On the same app dashboard, click **Add-ons**
2. Add **MySQL** (5.7 or 8.0)
3. Copy credentials from **Environment Variables** tab

### Step 3: Set Environment Variables
In Clever Cloud Dashboard → **Environment Variables**, add:

```env
# App Settings
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:<your-app-key>
APP_URL=https://your-app.cleverapps.io

# Database (from MySQL add-on)
DB_CONNECTION=mysql
DB_HOST=<mysql-host>
DB_PORT=3306
DB_DATABASE=<db-name>
DB_USERNAME=<db-user>
DB_PASSWORD=<db-password>

# Cloudinary (from https://cloudinary.com/console)
CLOUDINARY_CLOUD_NAME=<your-cloud-name>
CLOUDINARY_API_KEY=<your-api-key>
CLOUDINARY_API_SECRET=<your-api-secret>
CLOUDINARY_UPLOAD_PRESET=<your-upload-preset>

# Optional
IMAGE_MAX_KB=10240
LOG_CHANNEL=stack
CACHE_STORE=file
SESSION_DRIVER=file
```

#### Generate APP_KEY
Locally, run:
```powershell
php artisan key:generate --show
```
Copy the output (starts with `base64:...`) and paste into `APP_KEY`.

### Step 4: Deploy
1. Push changes to GitHub `main` branch:
```powershell
git push origin main
```
2. Clever Cloud automatically deploys on push
3. Monitor logs: Dashboard → **Logs** tab

### Step 5: Run Migrations
After first successful deployment:
1. In Clever Cloud Dashboard, go to **SSH Access**
2. Connect via SSH and run:
```bash
php artisan migrate --force
```

Or use the **Deployments** tab and add a post-deploy script.

---

## Option 2: Vercel (Full Laravel on Serverless)

Deploy full Laravel app on Vercel using `vercel-php` runtime.

### Prerequisites
- Vercel account at [vercel.com](https://vercel.com)
- Remote database (MySQL/PostgreSQL) accessible from Vercel
- Cloudinary credentials (optional for image features)

### How It Works
- `vercel.json` routes all requests to `api/index.php` which boots Laravel via `public/index.php`.
- `functions.api/index.php.runtime` uses `vercel-php@0.7.4` to build and run PHP code.
- `installCommand` installs Composer and Node deps; `buildCommand` runs Vite build.

### Step 1: Configure Environment Variables in Vercel
Set the following in Vercel Project → Settings → Environment Variables:

```env
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:<your-app-key>
APP_URL=https://<your-vercel-domain>

# Database (MySQL or PostgreSQL)
DB_CONNECTION=mysql
DB_HOST=<db-host>
DB_PORT=3306
DB_DATABASE=<db-name>
DB_USERNAME=<db-user>
DB_PASSWORD=<db-password>

# Cloudinary (optional)
CLOUDINARY_CLOUD_NAME=<your-cloud-name>
CLOUDINARY_API_KEY=<your-api-key>
CLOUDINARY_API_SECRET=<your-api-secret>
CLOUDINARY_UPLOAD_PRESET=<your-upload-preset>

# Serverless-friendly caches
APP_CONFIG_CACHE=/tmp/config.php
APP_EVENTS_CACHE=/tmp/events.php
APP_PACKAGES_CACHE=/tmp/packages.php
APP_ROUTES_CACHE=/tmp/routes.php
APP_SERVICES_CACHE=/tmp/services.php
VIEW_COMPILED_PATH=/tmp
CACHE_DRIVER=array
LOG_CHANNEL=stderr
SESSION_DRIVER=cookie
QUEUE_CONNECTION=sync
```

Generate `APP_KEY` locally:

```powershell
php artisan key:generate --show
```

### Step 2: Push to GitHub

```powershell
git add .
git commit -m "Deployable: Vercel serverless setup + live preview"
git push origin main
```

### Step 3: Create Vercel Project from GitHub
- Import the repo `AnyX0/portofolio-web` in Vercel.
- Ensure `Root Directory` is the repository root.
- Vercel will run `installCommand` (Composer + NPM) and `buildCommand` (Vite).

### Step 4: Run Migrations (First Deploy)
Use a one-time script from your local machine to run migrations against the remote DB or expose an admin route.

From local (pointing to the same DB):
```powershell
php artisan migrate --force
```

If DB is not accessible locally, consider a small protected endpoint to trigger migrations manually (not included by default for safety).

---

## Local Development

### Install Dependencies
```powershell
composer install
npm install
```

### Setup
```powershell
cp .env.example .env
php artisan key:generate
php artisan migrate
npm run build
```

### Run
```powershell
composer run dev
# Opens http://localhost:8000
# Also runs queue, logs, and Vite dev server concurrently
```

---

## Troubleshooting

### Migrations fail in production
- Ensure `DB_PASSWORD`, `DB_HOST` are correct in platform env
- Run migrations via SSH or add a post-deploy hook

### Assets not loading
- Build frontend assets before deploy:
  ```powershell
  npm run build
  ```
- Commit `public/build/` if needed

### Cloudinary uploads fail
- Verify `CLOUDINARY_CLOUD_NAME`, `CLOUDINARY_API_KEY`, `CLOUDINARY_API_SECRET`
- Check unsigned upload is enabled (no preset required if not using one)

### Storage/cache permissions
- Clever Cloud automatically sets correct permissions
- If needed, run: `chmod -R 755 storage bootstrap/cache`

---

## Production Optimizations

Optional, after initial deploy:

```powershell
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

This improves performance. Clear with:
```powershell
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

---

## Support

- **Clever Cloud Docs**: https://www.clever-cloud.com/doc/
- **Laravel Docs**: https://laravel.com/docs/
- **Cloudinary Docs**: https://cloudinary.com/documentation
