# ✅ Supabase + Render Setup Checklist

Panduan step-by-step lengkap yang sudah saya siapkan untuk Anda.

## ✅ Yang Sudah Selesai

### Step 1: Setup Supabase Database ✅ DONE (Anda)
- [x] Create Supabase account
- [x] Create database `portfolio-db` di Supabase
- [x] Create password/credentials
- [x] Copy connection details (host, port, db, user, password)
- [x] Enable SSL mode

**Credentials yang Anda dapat:**
```
DB_HOST=your-project.supabase.co
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=xxxxx
```

---

## 🚀 Langkah Selanjutnya (Step 2-8)

### Step 2: Update Environment File ⏭️ NEXT

**Di lokal Anda:**

1. Edit `.env` file dengan credentials Supabase:

```env
DB_CONNECTION=pgsql
DB_HOST=your-project.supabase.co
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=<your-password>
DB_SCHEMA=public
DB_SSLMODE=require
```

**Simpan file.**

---

### Step 3: Prepare Render Config ✅ DONE (Automated)

File sudah saya update:
- [x] `render.yaml` - Updated untuk PostgreSQL
- [x] `nixpacks.toml` - Updated dengan `pdo_pgsql`
- [x] `.env.example` - Updated untuk Supabase template

**Tidak perlu Anda edit, sudah siap.**

---

### Step 4: Push ke GitHub

**Di terminal lokal:**

```bash
# Check status
git status

# Add files
git add .env render.yaml nixpacks.toml DEPLOYMENT.md

# Commit
git commit -m "Setup Supabase PostgreSQL + Render deployment"

# Push
git push origin main
```

---

### Step 5: Deploy ke Render

**Di render.com:**

1. **Create Render Account** (jika belum)
   - Buka render.com → Sign up dengan GitHub

2. **New Web Service**
   - Dashboard → **New +** → **Web Service**
   - Select repository: `project_uas`

3. **Configure Service**
   - Name: `portfolio-laravel`
   - Region: Oregon (US West) atau terdekat
   - Branch: `main`
   - Runtime: PHP
   - Build Command: (auto dari nixpacks.toml)
   - Start Command: (auto dari nixpacks.toml)
   - Plan: **Free**

4. **Add Environment Variables** (Important!)
   
   Click **"Add Environment Variable"** untuk:
   
   ```env
   APP_NAME=Portfolio Laravel
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://portfolio-laravel.onrender.com
   
   # Generate APP_KEY di terminal lokal:
   # php artisan key:generate --show
   # Paste hasil di sini
   APP_KEY=base64:xxxxxxxxxxxxx
   
   # Supabase Database
   DB_CONNECTION=pgsql
   DB_HOST=your-project.supabase.co
   DB_PORT=5432
   DB_DATABASE=postgres
   DB_USERNAME=postgres
   DB_PASSWORD=<your-password>
   DB_SCHEMA=public
   DB_SSLMODE=require
   
   # Cloudinary
   CLOUDINARY_CLOUD_NAME=dducuhzso
   CLOUDINARY_API_KEY=381236954385957
   CLOUDINARY_API_SECRET=<your-secret>
   CLOUDINARY_UPLOAD_PRESET=portofolio_anyx
   
   # Cache & Session
   SESSION_DRIVER=file
   CACHE_DRIVER=file
   QUEUE_CONNECTION=sync
   LOG_CHANNEL=stack
   LOG_LEVEL=error
   ```

5. **Generate APP_KEY**
   
   **Di terminal lokal:**
   ```bash
   php artisan key:generate --show
   ```
   
   Copy output `base64:...` ke Render env var `APP_KEY`

6. **Click "Create Web Service"**
   
   Render akan memulai build (~3 menit):
   - Clone repo
   - Install dependencies (termasuk pdo_pgsql)
   - Build Laravel cache
   - Start aplikasi
   - Assign URL: `https://portfolio-laravel.onrender.com`

   **Monitor progress di Logs tab**

---

### Step 6: Run Migrations

**Setelah Render build selesai:**

1. Render dashboard → Service `portfolio-laravel`
2. Tab **"Shell"** → **"Launch Shell"**

3. **Di shell:**
   ```bash
   php artisan migrate --force
   ```
   
   Expected output:
   ```
   Migration table created successfully.
   Migrating: 2024_01_01_000000_create_users_table
   Migrated:  2024_01_01_000000_create_users_table
   Migrating: 2024_01_01_000001_create_projects_table
   Migrated:  2024_01_01_000001_create_projects_table
   ```

---

### Step 7: Create Admin User

**Di shell Render (lanjutan):**

```bash
php artisan tinker
```

**Paste:**
```php
$admin = new App\Models\User;
$admin->name = 'Admin';
$admin->email = 'admin@example.com';
$admin->password = bcrypt('your-secure-password');
$admin->save();
exit
```

---

### Step 8: Optional - Migrate Data dari MySQL Lokal

Jika sudah punya data di MySQL lokal, migrasi ke Supabase:

**Option A: Menggunakan pgloader (Recommended)**

1. Install pgloader:
   - macOS: `brew install pgloader`
   - Windows: Download dari pgloader.io

2. **Di terminal lokal:**
   ```bash
   pgloader mysql://root:password@127.0.0.1/portfolio_db \
            pgsql://postgres:supabase_password@your-project.supabase.co:5432/postgres
   ```

**Option B: Export CSV Manual**

1. Export tabel penting dari MySQL lokal ke CSV
2. Import ke Supabase via web console
3. Sesuaikan constraint & sequence

(Lihat DEPLOYMENT.md untuk detail lengkap)

---

## 🎉 Done!

### Access App

- **URL:** `https://portfolio-laravel.onrender.com`
- **Console:** `https://portfolio-laravel.onrender.com/console/access`
- **Login:**
  - Email: `admin@example.com`
  - Password: (yang Anda set di Step 7)

### Optional: Prevent Sleep

Render free tier sleep after 15 min. Setup cron ping:

1. Buka [cron-job.org](https://cron-job.org)
2. Sign up gratis
3. New cron job:
   - **Title:** Keep Portfolio Awake
   - **URL:** `https://portfolio-laravel.onrender.com`
   - **Interval:** Every 14 minutes
   - **Enabled:** Yes
4. Save

App akan **selalu awake!**

---

## 📋 File Changes Summary

| File | Change | Why |
|------|--------|-----|
| `.env` | Add Supabase creds | Connect ke PostgreSQL |
| `render.yaml` | Change to `pgsql` | Tell Render use PostgreSQL |
| `nixpacks.toml` | Add `pdo_pgsql` | Install PostgreSQL driver di Render |
| `.env.example` | Update template | Example untuk next deployment |
| `DEPLOYMENT.md` | Add Supabase section | Full walkthrough documentation |

---

## ⚡ Quick Checklist

- [ ] Step 2: Update `.env` lokal dengan Supabase credentials
- [ ] Step 4: Git push ke GitHub
- [ ] Step 5: Create Web Service di Render + add env vars
- [ ] Step 5.4: Generate & paste APP_KEY
- [ ] Step 5.6: Click "Create Web Service" → wait build
- [ ] Step 6: Run migrations di shell
- [ ] Step 7: Create admin user
- [ ] Step 8 (optional): Migrate data dari lokal
- [ ] Test: Akses `https://portfolio-laravel.onrender.com`
- [ ] Login dengan admin@example.com

---

## 🆘 Troubleshooting

**Build failed - "could not find driver (pgsql)"**
- ✅ Already fixed! nixpacks.toml include `php82Extensions.pdo_pgsql`

**Migration error - "table exists"**
- Supabase sudah create schema saat setup, rerun: `php artisan migrate --force`

**Connection refused**
- Check Supabase credentials di Render env vars
- Verify `DB_SSLMODE=require` ada
- Test connection lokal dulu

**App loading slow**
- Normal di free tier Render (sleep 15 min)
- Setup cron-job.org ping untuk prevent sleep

---

## 📚 Full Documentation

Baca [DEPLOYMENT.md](DEPLOYMENT.md) untuk:
- Detail lengkap tiap step
- Troubleshooting lebih lanjut
- Alternative setup (Railway, PlanetScale)
- Best practices production

---

**Ready? Mulai dari Step 2! 🚀**
