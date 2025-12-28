# 🚀 Portfolio Laravel - Deployment Guide

Panduan lengkap deploy Laravel portfolio dengan database remote - **100% gratis permanent!**

## 📋 Daftar Isi
- [Pilihan Hosting](#pilihan-hosting)
- [Deploy ke Render + Supabase (100% FREE)](#deploy-ke-render--supabase-100-free) ⭐ **Recommended**
- [Deploy ke Render + PlanetScale (MySQL)](#deploy-ke-render--planetscale-100-free-mysql)
- [Deploy ke Railway](#deploy-ke-railway-alternative)
- [Local Development](#local-development)
- [Environment Variables](#environment-variables)
- [Post-Deployment](#post-deployment)
- [Troubleshooting](#troubleshooting)

---

## 🎯 Pilihan Hosting

### Option 1: Render + Supabase (PostgreSQL) ⭐ **100% FREE PERMANENT** (RECOMMENDED)
- **App:** Render.com (free tier)
- **Database:** Supabase PostgreSQL (unlimited free tier)
- **Cost:** $0/bulan selamanya
- **Trade-off:** Sleep after 15 min (wake 30 detik) - solvable dengan cron ping
- **Keuntungan:** Database unlimited, generous free tier, fitur auth/storage
- **Best for:** Portfolio, demo, production projects

### Option 2: Render + PlanetScale (MySQL)
- **App:** Render.com (free tier)
- **Database:** PlanetScale (MySQL 5GB free)
- **Cost:** $0/bulan selamanya
- **Trade-off:** Sleep after 15 min, 5GB limit
- **Best for:** Portfolio, demo projects

### Option 3: Railway
- **App + MySQL:** All-in-one
- **Cost:** $5 credit/bulan (cukup untuk low traffic)
- **Trade-off:** Perlu top-up setelah credit habis
- **Best for:** Production apps, always-on

**Pilih mana?**
- Portfolio/demo gratis unlimited → **Render + Supabase** ⭐ (terbaik!)
- Portfolio/demo gratis terbatas → **Render + PlanetScale**
- Production serious → **Railway** ($5/bulan)

---

## 🆓 Deploy ke Render + Supabase (100% FREE)

**Anda sudah complete Step 1 - Supabase siap!** ✅

Lanjut dari Step 2...

### Overview
- **Total waktu:** ~20 menit (dari step 2)
- **Cost:** $0 permanent, unlimited database
- **Maintenance:** Auto-deploy dari GitHub

### Step 2: Update Environment File (2 menit)

#### 2.1 Update .env dengan Supabase Credentials

Buka `.env` lokal, ubah database config ke PostgreSQL:

```env
# Dari Supabase project Anda
DB_CONNECTION=pgsql
DB_HOST=<project-ref>.supabase.co
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=<your-supabase-password>
DB_SCHEMA=public
DB_SSLMODE=require
```

**Dimana mendapat credentials?**
- Supabase dashboard → Project → Settings → Database → Connection string
- Pilih `URI` atau copy individual fields (host, port, db, user, password)
- Ganti `<project-ref>` dengan project ref Anda (misal: `abc123def456.supabase.co`)

### Step 3: Prepare Render Config (3 menit)

#### 3.1 Update render.yaml untuk PostgreSQL

Edit atau buat `render.yaml` di root project:

```yaml
services:
  - type: web
    name: portfolio-laravel
    env: php
    buildCommand: |
      composer install --no-dev --optimize-autoloader
      php artisan config:cache
      php artisan route:cache
      php artisan view:cache
    startCommand: php artisan serve --host=0.0.0.0 --port=$PORT
    envVars:
      - key: APP_ENV
        value: production
      - key: APP_DEBUG
        value: false
      - key: APP_KEY
        generateValue: true
      - key: DB_CONNECTION
        value: pgsql
```

#### 3.2 Update nixpacks.toml untuk pdo_pgsql

Edit atau buat `nixpacks.toml` di root project:

```toml
[phases.setup]
nixPkgs = ['php82', 'php82Extensions.bcmath', 'php82Extensions.mbstring', 
           'php82Extensions.pdo', 'php82Extensions.pdo_pgsql']

[phases.build]
cmds = [
  'composer install --no-dev --optimize-autoloader',
  'php artisan config:cache',
  'php artisan route:cache',
  'php artisan view:cache'
]

[start]
cmd = 'php artisan serve --host=0.0.0.0 --port=$PORT'
```

⚠️ **PENTING:** `pdo_pgsql` harus ada supaya Laravel bisa konek ke PostgreSQL!

#### 3.3 Push ke GitHub

```bash
git add .env render.yaml nixpacks.toml
git commit -m "Add Supabase PostgreSQL config"
git push origin main
```

### Step 4: Deploy ke Render (5 menit)

#### 4.1 Create Render Account (jika belum)
1. Buka [render.com](https://render.com)
2. Sign up dengan GitHub
3. Authorize Render

#### 4.2 Create New Web Service
1. Dashboard → **"New +"** → **"Web Service"**
2. Connect repository: `project_uas`
3. Configure:
   - **Name:** `portfolio-laravel`
   - **Region:** Oregon (US West) atau terdekat
   - **Branch:** `main`
   - **Runtime:** PHP
   - **Build Command:** (auto dari nixpacks.toml)
   - **Start Command:** (auto dari nixpacks.toml)
   - **Plan:** **Free**

#### 4.3 Add Environment Variables

Scroll ke **"Environment Variables"** section.

Klik **"Add Environment Variable"** untuk setiap:

```env
# App Config
APP_NAME=Portfolio Laravel
APP_ENV=production
APP_DEBUG=false
APP_URL=https://portfolio-laravel.onrender.com

# Generate di local dulu (step 4.3)
APP_KEY=base64:xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

# Supabase PostgreSQL (dari Step 2.1)
DB_CONNECTION=pgsql
DB_HOST=<project-ref>.supabase.co
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=<your-supabase-password>
DB_SCHEMA=public
DB_SSLMODE=require

# Cloudinary (copy dari .env local)
CLOUDINARY_CLOUD_NAME=your_cloud_name
CLOUDINARY_API_KEY=your_api_key
CLOUDINARY_API_SECRET=your_api_secret
CLOUDINARY_UPLOAD_PRESET=your_preset

# Cache & Session
SESSION_DRIVER=file
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
LOG_CHANNEL=stack
LOG_LEVEL=error
```

#### 4.4 Generate APP_KEY

**Di terminal lokal:**
```bash
php artisan key:generate --show
```

Copy output `base64:...` ke Render env var `APP_KEY`

#### 4.5 Deploy

Klik **"Create Web Service"**

Render akan:
1. Clone repo dari GitHub
2. Install dependencies (termasuk pdo_pgsql)
3. Run build commands (~2-3 menit)
4. Start Laravel
5. Assign URL: `https://portfolio-laravel.onrender.com`

**Monitor build di dashboard → Logs tab**

### Step 5: Run Migrations (2 menit)

#### 5.1 Access Shell
1. Render dashboard → Service `portfolio-laravel`
2. Tab **"Shell"** → Klik **"Launch Shell"**

#### 5.2 Run Migrations
```bash
php artisan migrate --force
```

Output:
```
Migration table created successfully.
Migrating: 2024_01_01_000000_create_users_table
Migrated:  2024_01_01_000000_create_users_table
Migrating: 2024_01_01_000001_create_projects_table
Migrated:  2024_01_01_000001_create_projects_table
```

#### 5.3 Create Admin User
```bash
php artisan tinker
```

Paste:
```php
$admin = new App\Models\User;
$admin->name = 'Admin';
$admin->email = 'admin@example.com';
$admin->password = bcrypt('your-secure-password');
$admin->save();
exit
```

### Step 6: Migrate Data dari MySQL Lokal (Optional tapi Recommended)

Jika sudah punya data di MySQL lokal, migrasi ke Supabase:

#### 6.1 Export dari MySQL Lokal

**Di terminal lokal:**
```bash
mysqldump -u root -p portfolio_db > local_backup.sql
```

Jika ada password:
```bash
mysqldump -u root -pYOUR_PASSWORD portfolio_db > local_backup.sql
```

#### 6.2 Edit SQL Dump (Sesuaikan dengan PostgreSQL)

Buka `local_backup.sql`, ganti:
- `AUTO_INCREMENT` → hapus atau ganti dengan `SERIAL`
- `unsigned` → hapus
- `ENGINE=InnoDB` → hapus
- Tipe `json` → tetap `json` (Postgres support)

**Atau gunakan pgloader (lebih mudah):**
```bash
# Install pgloader terlebih dahulu
# macOS: brew install pgloader
# Windows: download dari pgloader.io

pgloader --version  # cek instalasi

pgloader mysql://root:password@127.0.0.1/portfolio_db \
         pgsql://postgres:supabase_password@project.supabase.co:5432/postgres

```

#### 6.3 Alternative: Import via Supabase Web Console

1. Supabase dashboard → SQL Editor
2. Create new query
3. Paste SQL dump (sudah diedit)
4. Klik Run

Atau:
1. Supabase dashboard → Database → Backups
2. Upload `.sql` file

#### 6.4 Verify Data

**Di Render shell:**
```bash
php artisan tinker
```

```php
# Check users
App\Models\User::count()

# Check projects
App\Models\Project::count()

# View recent projects
App\Models\Project::latest()->limit(5)->get()

exit
```

### Step 7: Prevent Sleep (Optional - 3 menit)

Render free tier sleep after 15 min. Solusi: ping otomatis.

#### 7.1 Setup Cron-Job.org
1. Buka [cron-job.org](https://cron-job.org/en/)
2. Sign up gratis
3. Create new cron job:
   - **Title:** Keep Render Awake
   - **URL:** `https://portfolio-laravel.onrender.com`
   - **Interval:** Every 14 minutes
   - **Enabled:** Yes
4. Save

App akan **selalu awake** 24/7!

**Alternative:** UptimeRobot.com (free monitoring + ping)

### Step 8: Access App 🎉

**URL:** `https://portfolio-laravel.onrender.com`

**Console:** `https://portfolio-laravel.onrender.com/console/access`

**Login:**
- Email: `admin@example.com` (atau yang Anda set di Step 5.3)
- Password: (yang Anda set di Step 5.3)

---

## 🆓 Deploy ke Render + PlanetScale (100% FREE - MySQL)

### Overview
- **Total waktu:** ~20 menit
- **Cost:** $0 permanent
- **Maintenance:** Auto-deploy dari GitHub

### Step 1: Setup PlanetScale Database (7 menit)

#### 1.1 Create PlanetScale Account
1. Buka [planetscale.com](https://planetscale.com)
2. Sign up dengan GitHub (gratis)
3. Verify email

#### 1.2 Create Database
1. Dashboard → **"Create a database"**
2. Database name: `portfolio-db`
3. Region: **AWS us-east-1** (recommended)
4. Plan: **Hobby** (free 5GB)
5. Klik **"Create database"**

#### 1.3 Create Password
1. Database `portfolio-db` → Tab **"Connect"**
2. Klik **"Create password"**
3. Name: `production`
4. Klik **"Create password"**

#### 1.4 Copy Connection Details
**Select framework:** Laravel

Copy credentials yang muncul:
```env
DB_HOST=aws.connect.psdb.cloud
DB_PORT=3306
DB_DATABASE=portfolio-db
DB_USERNAME=xxxxxxxxxx
DB_PASSWORD=pscale_pw_xxxxxxxxxx
```

⚠️ **PENTING:** Simpan password, tidak akan muncul lagi!

#### 1.5 Enable Connect from Laravel
1. Tab **"Settings"**
2. **"Allow web console"** → Enable
3. **"Automatically copy migration data"** → Enable (recommended)

### Step 2: Prepare Repository (3 menit)

#### 2.1 Create render.yaml
Buat file baru `render.yaml` di root project:

```yaml
services:
  - type: web
    name: portfolio-laravel
    env: php
    buildCommand: |
      composer install --no-dev --optimize-autoloader
      php artisan config:cache
      php artisan route:cache
      php artisan view:cache
    startCommand: php artisan serve --host=0.0.0.0 --port=$PORT
    envVars:
      - key: APP_ENV
        value: production
      - key: APP_DEBUG
        value: false
      - key: APP_KEY
        generateValue: true
      - key: DB_CONNECTION
        value: mysql
```

#### 2.2 Push ke GitHub
```bash
git add render.yaml
git commit -m "Add Render deployment config"
git push origin main
```

### Step 3: Deploy ke Render (5 menit)

#### 3.1 Create Render Account
1. Buka [render.com](https://render.com)
2. Sign up dengan GitHub
3. Authorize Render

#### 3.2 Create New Web Service
1. Dashboard → **"New +"** → **"Web Service"**
2. Connect repository: `project_uas`
3. Configure:
   - **Name:** `portfolio-laravel`
   - **Region:** Oregon (US West)
   - **Branch:** `main`
   - **Runtime:** PHP
   - **Build Command:** (auto dari render.yaml)
   - **Start Command:** (auto dari render.yaml)
   - **Plan:** **Free**

#### 3.3 Add Environment Variables
Scroll ke **"Environment Variables"** section.

Klik **"Add Environment Variable"** untuk setiap:

```env
# App Config
APP_NAME=Portfolio Laravel
APP_ENV=production
APP_DEBUG=false
APP_URL=https://portfolio-laravel.onrender.com

# Generate di local dulu
APP_KEY=base64:xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

# PlanetScale Database (paste dari Step 1.4)
DB_CONNECTION=mysql
DB_HOST=aws.connect.psdb.cloud
DB_PORT=3306
DB_DATABASE=portfolio-db
DB_USERNAME=your_username
DB_PASSWORD=pscale_pw_xxxxxxxxxx
MYSQL_ATTR_SSL_CA=/etc/ssl/certs/ca-certificates.crt

# Cloudinary (copy dari .env local)
CLOUDINARY_CLOUD_NAME=your_cloud_name
CLOUDINARY_API_KEY=your_api_key
CLOUDINARY_API_SECRET=your_api_secret
CLOUDINARY_UPLOAD_PRESET=your_preset

# Cache & Session
SESSION_DRIVER=file
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
LOG_CHANNEL=stack
LOG_LEVEL=error
```

#### 3.4 Generate APP_KEY
**Di terminal lokal:**
```bash
php artisan key:generate --show
```
Copy output `base64:...` ke Render env var `APP_KEY`

#### 3.5 Deploy
Klik **"Create Web Service"**

Render akan:
1. Clone repo dari GitHub
2. Run build commands (~3 menit)
3. Start Laravel
4. Assign URL: `https://your-app.onrender.com`

### Step 4: Run Migrations (2 menit)

#### 4.1 Access Shell
1. Render dashboard → Service `portfolio-laravel`
2. Tab **"Shell"** → Klik **"Launch Shell"**

#### 4.2 Run Migrations
```bash
php artisan migrate --force
```

Output:
```
Migration table created successfully.
Migrating: 2024_01_01_000000_create_projects_table
Migrated:  2024_01_01_000000_create_projects_table
```

#### 4.3 Create Admin User
```bash
php artisan tinker
```

Paste:
```php
$admin = new App\Models\User;
$admin->name = 'Admin';
$admin->email = 'admin@example.com';
$admin->password = bcrypt('your-secure-password');
$admin->save();
exit
```

### Step 5: Prevent Sleep (3 menit) - OPTIONAL

Render free tier **sleep after 15 menit** inactivity. Solusi: ping otomatis.

#### 5.1 Setup Cron-Job.org
1. Buka [cron-job.org](https://cron-job.org/en/)
2. Sign up gratis
3. Create new cron job:
   - **Title:** Keep Render Awake
   - **URL:** `https://your-app.onrender.com`
   - **Interval:** Every 14 minutes
   - **Enabled:** Yes
4. Save

App akan **selalu awake** selama ada ping!

**Alternative:** UptimeRobot.com (free monitoring + ping)

### Step 6: Access App 🎉

URL: `https://your-app.onrender.com`

**Console:** `https://your-app.onrender.com/console/access`

**Login:**
- Email: `admin@example.com`
- Password: (yang Anda set di Step 4.3)

---

## 🚂 Deploy ke Railway (Alternative)

Railway lebih simple tapi **tidak free permanent**.

### Keuntungan Railway
- ✅ All-in-one (app + MySQL satu tempat)
- ✅ Zero config MySQL
- ✅ Faster setup (~10 menit)
- ✅ No sleep time

### Kekurangan
- ❌ $5 credit/bulan (perlu top-up)
- ❌ Tidak free permanent

### Step 1: Persiapan Repository (5 menit)

#### 1.1 Push ke GitHub
```bash
git init
git add .
git commit -m "Initial commit"
git remote add origin https://github.com/username/your-repo.git
git branch -M main
git push -u origin main
```

#### 1.2 File sudah siap ✅
- ✅ `Procfile`
- ✅ `nixpacks.toml`

### Step 2: Setup Railway (2 menit)

1. Buka [railway.app](https://railway.app)
2. Login dengan GitHub
3. Authorize Railway

### Step 3: Deploy App (5 menit)

1. **"New Project"** → **"Deploy from GitHub repo"**
2. Select `project_uas`
3. Wait build (~2-3 menit)

### Step 4: Add MySQL (3 menit)

1. Project dashboard → **"+ New"**
2. **"Database"** → **"Add MySQL"**
3. Wait provision (~1 menit)

### Step 5: Configure Environment (5 menit)

Klik Laravel service → **"Variables"**

Add variables:
```env
APP_NAME=Portfolio Laravel
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app.up.railway.app
APP_KEY=base64:xxxxxxxxxx

# Database (reference MySQL service)
DB_CONNECTION=mysql
DB_HOST=${MYSQLHOST}
DB_PORT=${MYSQLPORT}
DB_DATABASE=${MYSQLDATABASE}
DB_USERNAME=${MYSQLUSER}
DB_PASSWORD=${MYSQLPASSWORD}

# Cloudinary
CLOUDINARY_CLOUD_NAME=your_cloud
CLOUDINARY_API_KEY=your_key
CLOUDINARY_API_SECRET=your_secret
CLOUDINARY_UPLOAD_PRESET=your_preset

SESSION_DRIVER=file
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
```

Klik **"Deploy"**

### Step 6: Run Migrations (2 menit)

Railway Console:
```bash
php artisan migrate --force
```

Create admin via tinker (sama seperti Render)

### Step 7: Access 🎉

URL dari Railway dashboard → **"Domains"**

---

## 🖥️ Local Development

### Prerequisites
- PHP 8.3+
- Composer
- MySQL 8.0+
- Node.js & npm

### Setup
```bash
# Clone
git clone <your-repo>
cd project_uas

# Install
composer install
npm install

# Configure
cp .env.example .env
php artisan key:generate

# Database
php artisan migrate

# Assets
npm run build

# Serve
php artisan serve
```

---

## 🔐 Environment Variables

### Required Variables

| Variable | Description | Example |
|----------|-------------|---------|
| `APP_ENV` | Environment | `production` |
| `APP_DEBUG` | Debug mode | `false` |
| `APP_KEY` | Encryption key | `base64:...` |
| `APP_URL` | Public URL | `https://your-app.onrender.com` |
| `DB_HOST` | Database host | `aws.connect.psdb.cloud` (PlanetScale) |
| `DB_PORT` | Database port | `3306` |
| `DB_DATABASE` | Database name | `portfolio-db` |
| `DB_USERNAME` | Database user | (from PlanetScale) |
| `DB_PASSWORD` | Database password | `pscale_pw_xxx` |
| `CLOUDINARY_CLOUD_NAME` | Cloudinary cloud | Your cloud name |
| `CLOUDINARY_API_KEY` | API key | Your API key |
| `CLOUDINARY_API_SECRET` | API secret | Your secret |
| `CLOUDINARY_UPLOAD_PRESET` | Upload preset | Your preset |

### PlanetScale SSL (Render only)
```env
MYSQL_ATTR_SSL_CA=/etc/ssl/certs/ca-certificates.crt
```

---

## 📦 Post-Deployment

### Auto-Deploy
Kedua platform **auto-deploy** saat push:
```bash
git add .
git commit -m "Update feature"
git push origin main
# Auto-deploy dalam 2-3 menit
```

### Cache Optimization
**Via console:**
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Custom Domain (Render)
1. Service → **"Settings"** → **"Custom Domain"**
2. Add domain: `portfolio.yourdomain.com`
3. Set CNAME:
   ```
   Type: CNAME
   Name: portfolio
   Value: your-app.onrender.com
   ```

### SSL Certificate
Kedua platform **auto-provision SSL** (Let's Encrypt):
- Render: Instant untuk .onrender.com subdomain
- Railway: Instant untuk .railway.app subdomain
- Custom domain: 5-10 menit setelah DNS propagation

---

## 🐛 Troubleshooting

### PlanetScale Connection Failed

**Symptom:** `SQLSTATE[HY000] [2002]`

**Solutions:**
1. Check credentials match PlanetScale
2. Add SSL certificate path:
   ```env
   MYSQL_ATTR_SSL_CA=/etc/ssl/certs/ca-certificates.crt
   ```
3. Verify PlanetScale database is **Active**
4. Test connection via PlanetScale web console

### Render Build Failed

**Symptom:** Build error logs

**Solutions:**
1. Check `render.yaml` syntax
2. Verify `composer.json` dependencies
3. Check PHP version compatible (8.2+)
4. View build logs untuk error detail

**Common fixes:**
```bash
# Regenerate lock file
composer update --lock

# Test build locally
composer install --no-dev --optimize-autoloader
```

### App Sleeping (Render)

**Symptom:** First load slow (30 sec)

**Solutions:**
1. Use cron-job.org ping (free) - **Recommended**
2. Use UptimeRobot.com (free monitoring)
3. Upgrade to Render paid ($7/mo, no sleep)
4. Accept trade-off untuk portfolio demo

### 500 Error After Deploy

**Solutions:**
```bash
# Via console
php artisan key:generate --force
php artisan migrate --force
php artisan config:cache
php artisan cache:clear
```

Check logs:
```bash
tail storage/logs/laravel.log
```

### Cloudinary SSL Error

**Symptom:** Images upload tapi tidak load

**Solution:**
Verify `CloudinaryImageFetcher.php` has:
```php
Http::withoutVerifying()
```

### Session/CSRF Token Mismatch

**Symptom:** 419 errors on form submit

**Solutions:**
1. Set correct `APP_URL` (with https://)
2. Clear config cache:
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```
3. Check `SESSION_DRIVER=file`

---

## 💰 Cost Comparison

| Platform | App | Database | Monthly | Annual | Sleep? | Limit |
|----------|-----|----------|---------|--------|--------|-------|
| **Render + Supabase** | Free | Free Unlimited | **$0** | **$0** | Yes (15 min) | Unlimited ✅ |
| **Render + PlanetScale** | Free | Free 5GB | **$0** | **$0** | Yes (15 min) | 5GB |
| **Railway** | Included | Included | ~$3-5 | ~$36-60 | No | Included |
| **Render Paid** | $7 | External | $7+ | $84+ | No | - |

**Verdict:** 
- **Best free option:** Render + Supabase = **$0/tahun, unlimited** 🎉⭐
- **Second best:** Render + PlanetScale = **$0/tahun, 5GB limit**
- **Production:** Railway = **$36-60/tahun** (no sleep)

---

## 🔄 Migration Between Platforms

### Railway → Render + PlanetScale

1. **Export data dari Railway MySQL:**
   ```bash
   # Via Railway console
   mysqldump -h $MYSQLHOST -u $MYSQLUSER -p$MYSQLPASSWORD $MYSQLDATABASE > backup.sql
   ```

2. **Import ke PlanetScale:**
   - PlanetScale web console → Import → Upload `backup.sql`
   - Or use PlanetScale CLI:
     ```bash
     pscale shell portfolio-db main < backup.sql
     ```

3. **Update env vars di Render:**
   - Settings → Environment → Update DB credentials

4. **Manual redeploy:**
   - Render dashboard → Manual Deploy

### Local → Render + PlanetScale

1. **Export local database:**
   ```bash
   mysqldump -u root -p portfolio_db > local_backup.sql
   ```

2. **Import ke PlanetScale** (same as above)

3. **Deploy to Render** (follow Step 3)

---

## 📚 Resources

### Official Docs
- [Render Documentation](https://render.com/docs)
- [PlanetScale Documentation](https://planetscale.com/docs)
- [Railway Documentation](https://docs.railway.app)
- [Laravel Deployment Guide](https://laravel.com/docs/deployment)
- [Cloudinary Laravel Integration](https://cloudinary.com/documentation/laravel_integration)

### Community
- [Render Discord](https://discord.gg/render)
- [PlanetScale Discord](https://discord.gg/planetscale)
- [Railway Discord](https://discord.gg/railway)

### Tools
- [Cron-Job.org](https://cron-job.org) - Free cron jobs
- [UptimeRobot](https://uptimerobot.com) - Free monitoring
- [PlanetScale CLI](https://github.com/planetscale/cli) - Database management

---

## 🎯 Quick Reference

### Render Commands
```bash
# View logs
render logs

# Shell access
render shell

# Redeploy
render deploy
```

### PlanetScale CLI
```bash
# Install
brew install planetscale/tap/pscale  # macOS
# or download from planetscale.com/cli

# Login
pscale auth login

# Connect to database
pscale shell portfolio-db main

# Create backup
pscale backup create portfolio-db main

# List branches
pscale branch list portfolio-db
```

### Laravel Production Commands
```bash
# Migrations
php artisan migrate --force
php artisan migrate:status

# Cache
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Clear cache
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
php artisan optimize:clear

# Check status
php artisan about

# View routes
php artisan route:list

# Database status
php artisan db:show
```

### Git Deployment
```bash
# Check status
git status

# Add changes
git add .

# Commit
git commit -m "Your message"

# Push (triggers auto-deploy)
git push origin main

# View deploy status
# Check Render/Railway dashboard
```

---

## 🎓 Best Practices

### Security
1. ✅ Set `APP_DEBUG=false` di production
2. ✅ Use strong `APP_KEY` (auto-generated)
3. ✅ Never commit `.env` file
4. ✅ Use HTTPS only (both platforms provide SSL)
5. ✅ Rotate Cloudinary API keys regularly

### Performance
1. ✅ Enable all Laravel caches (config, route, view)
2. ✅ Use Cloudinary image optimization
3. ✅ Enable browser caching
4. ✅ Use CDN untuk assets (Cloudinary sudah CDN)
5. ✅ Monitor database query performance

### Maintenance
1. ✅ Regular backups (PlanetScale auto-backup daily)
2. ✅ Monitor error logs via Render/Railway dashboard
3. ✅ Update dependencies monthly: `composer update`
4. ✅ Test deploys di staging branch dulu
5. ✅ Use semantic versioning untuk git tags

---

**🚀 Deploy Sekarang!**

**Gratis permanent:** ⭐ Pilih **Render + PlanetScale**
**Lebih stabil:** Pilih **Railway** ($5/bulan)

Kedua-duanya deploy dari GitHub dengan auto-deploy! 🎉

**Questions?** Check [Troubleshooting](#troubleshooting) atau community Discord!
