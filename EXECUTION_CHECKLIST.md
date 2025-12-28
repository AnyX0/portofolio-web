# ✅ AUTOMATED DEPLOYMENT - EXECUTION CHECKLIST

**STATUS:** Ready to Deploy ✅

---

## 🎯 STEP-BY-STEP EKSEKUSI

### ✅ STEP 1: Push ke GitHub (1 menit)

**Di terminal lokal Anda, ketik:**

```bash
cd E:\Andi\Documents\Kuliah\PEMROGRAMAN\ MOBILE\ -\ SMT5\StudioProjects\project_uas
bash deploy.sh
```

**Atau jika bash tidak tersedia (Windows), gunakan:**

```powershell
git add .
git commit -m "Setup Supabase PostgreSQL + Render deployment - portofolio-anyx"
git push origin main
php artisan key:generate --show
```

**Copy output APP_KEY untuk Step 2**

---

### ⏳ STEP 2: Deploy ke Render (3-5 menit)

**MANUAL di Render Dashboard:**

1. **Buka:** https://render.com/dashboard

2. **New Web Service:**
   ```
   New + → Web Service → Select project_uas
   ```

3. **Configure:**
   ```
   Name: portofolio-anyx
   Region: Singapore
   Branch: main
   Plan: Free
   ```

4. **Add Environment Variables** (SEMUA INI!)

   Paste di Render environment variables:

   ```
   APP_NAME=Portofolio Anyx
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://portofolio-anyx.onrender.com
   APP_KEY=base64:AbxgP5FhppzP2uRsTo+ichFwdVqDBeChzE63hLaEnb8=
   DB_CONNECTION=pgsql
   DB_HOST=db.dvjazmruokrvydtneyfp.supabase.co
   DB_PORT=5432
   DB_DATABASE=postgres
   DB_USERNAME=postgres
   DB_PASSWORD=@17082003Yaudah
   DB_SCHEMA=public
   DB_SSLMODE=require
   CLOUDINARY_CLOUD_NAME=dducuhzso
   CLOUDINARY_API_KEY=381236954385957
   CLOUDINARY_API_SECRET=[FILL_YOUR_SECRET]
   CLOUDINARY_UPLOAD_PRESET=portofolio_anyx
   SESSION_DRIVER=file
   CACHE_DRIVER=file
   QUEUE_CONNECTION=sync
   LOG_CHANNEL=stack
   LOG_LEVEL=error
   ```

5. **Click "Create Web Service"**

6. **Wait 2-3 minutes** untuk build selesai

   Monitor di **Logs tab** - tunggu sampai status "Live"

---

### ✅ STEP 3: Run Migrations (1 menit)

Setelah status berubah ke **"Live"**:

1. **Open Shell**
   - Service dashboard → Tab "Shell" → "Launch Shell"

2. **Run Command di Shell:**

   ```bash
   php artisan migrate --force
   ```

   Expected output:
   ```
   Migration table created successfully.
   Migrating: 2024_01_01_000000_create_users_table
   Migrated:  2024_01_01_000000_create_users_table
   ```

3. **Create Admin User** (masih di shell):

   ```bash
   php artisan tinker
   ```

   Then paste:
   ```php
   $admin = new App\Models\User;
   $admin->name = 'Admin Anyx';
   $admin->email = 'admin@portofolio-anyx.com';
   $admin->password = bcrypt('YourSecurePassword123!');
   $admin->save();
   exit
   ```

   Expected:
   ```
   Psy Shell v0.11.x
   >>> $admin = new App\Models\User;
   >>> ... (enter commands)
   >>> exit
   ```

---

## 🎉 SELESAI!

### Akses App Anda:

```
🌐 URL: https://portofolio-anyx.onrender.com
🛠️  Console: https://portofolio-anyx.onrender.com/console/access

👤 Email: admin@portofolio-anyx.com
🔐 Password: YourSecurePassword123!
```

---

## ⏱️ TIMELINE

| Step | Time | Status |
|------|------|--------|
| 1. Git Push | 1 min | ⏳ Eksekusi |
| 2. Render Deploy | 3-5 min | ⏳ Tunggu build |
| 3. Migrations | 1 min | ⏳ Run di shell |
| **TOTAL** | **~5-10 min** | ✅ **LIVE** |

---

## ✅ PRE-FLIGHT CHECKLIST

Sebelum eksekusi, pastikan:

- [ ] `.env` sudah update (✅ DONE)
- [ ] `render.yaml` sudah update (✅ DONE)
- [ ] `nixpacks.toml` sudah update (✅ DONE)
- [ ] GitHub repository sudah create
- [ ] Supabase project sudah create (✅ DONE)
- [ ] Render account sudah buat
- [ ] Cloudinary secret siap

---

## 🐛 ERROR HANDLING

| Error | Solution |
|-------|----------|
| "Build Failed: could not find driver" | ✅ Sudah fixed di nixpacks.toml |
| "Connection refused" | Verify password `@17082003Yaudah` |
| "Table already exists" | Run: `php artisan migrate --force` |
| "401 Unauthorized" | Check email/password login |
| Build stuck | Refresh Render page, check logs |

---

## 🎯 READY?

**Start from STEP 1 sekarang!** ➡️

Saya sudah siapkan semua files:
- ✅ `.env` dengan Supabase credentials
- ✅ `render.yaml` untuk Render
- ✅ `nixpacks.toml` dengan pdo_pgsql
- ✅ `deploy.sh` untuk git push otomatis
- ✅ `post-deploy.sh` untuk Render shell otomatis
- ✅ `QUICK_DEPLOYMENT_GUIDE.md` dokumentasi lengkap

**Eksekusi Step 1 sekarang di terminal!** 🚀
