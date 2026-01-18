# Vercel Deployment Setup 🚀

Quick guide untuk deploy Laravel portfolio ke Vercel.

## Prerequisites

- ✅ Code sudah di-push ke GitHub (completed!)
- ✅ Akun Vercel ([vercel.com](https://vercel.com))
- ✅ Database MySQL/PostgreSQL yang accessible dari internet (Supabase, PlanetScale, Aiven, dll)
- ✅ Akun Cloudinary untuk image storage

---

## Step 1: Import Project ke Vercel

1. Buka [vercel.com/new](https://vercel.com/new)
2. Pilih **Import Git Repository**
3. Connect GitHub dan pilih repo: `AnyX0/portofolio-web`
4. Framework Preset: **Other** (sudah auto-detect dari vercel.json)
5. Root Directory: **Leave blank** (gunakan root folder)
6. Klik **Deploy** (akan gagal dulu karena belum set env vars - normal!)

---

## Step 2: Set Environment Variables

Di Vercel Project → **Settings** → **Environment Variables**, tambahkan:

### Required Variables

```env
# Application
APP_NAME="Portfolio Laravel"
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:GENERATE_THIS_LOCALLY
APP_URL=https://your-project.vercel.app

# Database (contoh: PlanetScale, Supabase, Aiven)
DB_CONNECTION=mysql
DB_HOST=your-db-host.mysql.database.azure.com
DB_PORT=3306
DB_DATABASE=portfolio
DB_USERNAME=your-username
DB_PASSWORD=your-password

# Cloudinary (dari https://cloudinary.com/console)
CLOUDINARY_CLOUD_NAME=your-cloud-name
CLOUDINARY_API_KEY=123456789012345
CLOUDINARY_API_SECRET=your-api-secret
CLOUDINARY_UPLOAD_PRESET=your-preset

# Cache & Session (untuk serverless)
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

# Optional
IMAGE_MAX_KB=10240
```

### Generate APP_KEY

Di lokal, jalankan:

```powershell
php artisan key:generate --show
```

Copy output (contoh: `base64:abc123...xyz`) dan paste ke `APP_KEY`.

---

## Step 3: Redeploy

1. Setelah env vars tersimpan, di tab **Deployments**
2. Klik **•••** menu pada deployment terakhir
3. Pilih **Redeploy**
4. Tunggu build selesai (~2-5 menit)

---

## Step 4: Run Database Migrations

Karena Vercel serverless, migration harus dari lokal ke DB remote.

### Cara 1: Dari Lokal (Recommended)

1. Edit `.env` lokal, arahkan ke DB production:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=your-production-db-host
   DB_PORT=3306
   DB_DATABASE=portfolio
   DB_USERNAME=...
   DB_PASSWORD=...
   ```

2. Run migrations:
   ```powershell
   php artisan migrate --force
   ```

3. Seed data awal (optional):
   ```powershell
   php artisan db:seed --force
   ```

4. Kembalikan `.env` lokal ke database lokal.

### Cara 2: Setup Project Lokal (Alternatif)

Jika ingin test project dengan live_url:

```powershell
php artisan project:ensure social-ground-coffee-shop-web-with-member-page --title="Social Ground Coffee Shop" --summary="Web dengan member page" --tech_stack="Laravel, Tailwind" --live_url="https://example.com" --published=1
```

---

## Step 5: Verify Deployment

1. **Test endpoint API:**
   - `https://your-project.vercel.app/api/projects/slug/neon-banking-mobile`
   - Should return JSON dengan project data

2. **Test live preview:**
   - Buka detail page project
   - Klik tombol "Live Preview"
   - Modal akan menampilkan iframe dari `live_url`

3. **Test admin:**
   - Create admin user via lokal (pointing to prod DB):
     ```powershell
     php artisan tinker
     ```
     ```php
     $admin = new App\Models\User;
     $admin->name = 'Admin';
     $admin->email = 'admin@example.com';
     $admin->password = bcrypt('password123');
     $admin->save();
     exit
     ```
   - Access: `https://your-project.vercel.app/console/access`

---

## Free Database Options

| Provider | Free Tier | Notes |
|----------|-----------|-------|
| **PlanetScale** | 5GB storage | MySQL-compatible, serverless |
| **Supabase** | 500MB | PostgreSQL, includes storage & auth |
| **Aiven** | 1GB RAM | MySQL/PostgreSQL, 30-day trial |
| **Railway** | $5 credit | MySQL, PostgreSQL, MongoDB |

---

## Troubleshooting

### Build Error: Composer/NPM not found
- ✅ `installCommand` sudah ada di `vercel.json`
- Check Vercel build logs untuk error detail

### 500 Error: APP_KEY not set
- Pastikan `APP_KEY` di-set di Environment Variables
- Redeploy setelah env vars ditambahkan

### 404: Route not found
- Check `api/index.php` dan `public/index.php` ada
- Pastikan `vercel.json` routing sudah benar (✅ already configured)

### Database Connection Failed
- Verify `DB_HOST`, `DB_PORT`, `DB_DATABASE`, credentials
- Pastikan database allow connections dari IP mana saja (0.0.0.0/0)
- Untuk Supabase: gunakan `DB_SSLMODE=require`

### Live Preview tidak muncul
- Pastikan project punya `live_url` yang valid (https://...)
- Jika situs target memblokir embed (X-Frame-Options), gunakan tombol "Kunjungi Project"
- Check browser console untuk CORS errors

---

## Production Optimizations (Optional)

Setelah deploy stabil, jalankan dari lokal (to prod DB):

```powershell
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

**Clear cache:**
```powershell
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

---

## Support Links

- 📖 [Laravel Vercel Guide](https://laravel.com/docs/deployment#vercel)
- 🔧 [Vercel PHP Runtime](https://github.com/vercel-community/php)
- 🗄️ [PlanetScale](https://planetscale.com)
- 🗄️ [Supabase](https://supabase.com)
- 🖼️ [Cloudinary](https://cloudinary.com)

---

**Happy Deploying! 🚀**
