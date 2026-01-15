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

## Option 2: Vercel (Frontend Only)

If you want a separate frontend on Vercel with API proxy to Clever Cloud backend:

### Prerequisites
- Vercel account at [vercel.com](https://vercel.com)
- Clever Cloud backend already deployed (see Option 1)

### Step 1: Create Vercel Project
1. Connect your GitHub repo to Vercel
2. Create a new project (can be a subfolder or separate repo for frontend)

### Step 2: Configure vercel.json
A `vercel.json` is already in the root directory with API rewrites. Update it:

```json
{
  "rewrites": [
    {
      "source": "/api/(.*)",
      "destination": "https://your-app.cleverapps.io/$1"
    }
  ]
}
```

Replace `your-app.cleverapps.io` with your actual Clever Cloud app URL.

### Step 3: Build & Deploy
Vercel automatically builds and deploys on push to GitHub.

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
