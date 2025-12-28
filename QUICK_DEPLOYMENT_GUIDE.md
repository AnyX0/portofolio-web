# 🚀 PORTOFOLIO ANYX - AUTOMATED DEPLOYMENT GUIDE

**Project:** portofolio-anyx  
**Database:** Supabase PostgreSQL  
**Hosting:** Render.com  
**Cost:** $0/bulan selamanya ✅

---

## ⚡ QUICK START (5 menit)

### Phase 1: Push ke GitHub (1 menit)

**Di terminal lokal, jalankan:**

```bash
bash deploy.sh
```

Script ini akan:
1. ✅ Add semua files
2. ✅ Commit ke git
3. ✅ Push ke GitHub main
4. ✅ Generate APP_KEY
5. ✅ Display next steps

**OUTPUT EXPECTED:**
```
✅ GIT PUSH COMPLETE!
Generated APP_KEY: base64:...
```

---

### Phase 2: Deploy ke Render (3 menit)

**Di render.com dashboard:**

#### Step 1: Create Web Service
1. Buka https://render.com/dashboard
2. **New +** → **Web Service**
3. Select repository: `project_uas`

#### Step 2: Configure Service
```
Name: portofolio-anyx
Region: Singapore (atau terdekat)
Branch: main
Runtime: PHP
Build Command: (auto)
Start Command: (auto)
Plan: Free
```

#### Step 3: Add Environment Variables

**Klik "Add Environment Variable" untuk setiap:**

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
CLOUDINARY_API_SECRET=<paste_your_secret>
CLOUDINARY_UPLOAD_PRESET=portofolio_anyx
SESSION_DRIVER=file
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
LOG_CHANNEL=stack
LOG_LEVEL=error
```

#### Step 4: Create Web Service
Klik **"Create Web Service"**

**Render akan build (~2-3 menit)**

Monitor di: **Logs tab** → Lihat progress build

---

### Phase 3: Run Migrations & Create Admin (1 menit)

Setelah build **SELESAI** (status: "Live"):

#### Step 1: Access Shell
1. Service dashboard → Tab **"Shell"**
2. Klik **"Launch Shell"**

#### Step 2: Run Script
**Di shell Render, paste:**

```bash
php artisan migrate --force
```

Expected:
```
Migration table created successfully.
Migrating: 2024_01_01_...
Migrated: 2024_01_01_...
```

#### Step 3: Create Admin User
**Still di shell:**

```bash
php artisan tinker
```

**Then paste:**
```php
$admin = new App\Models\User;
$admin->name = 'Admin Anyx';
$admin->email = 'admin@portofolio-anyx.com';
$admin->password = bcrypt('YourSecurePassword123!');
$admin->save();
exit
```

---

## ✅ DEPLOYMENT DONE!

### 🎉 Access Your App

| Item | Value |
|------|-------|
| **URL** | https://portofolio-anyx.onrender.com |
| **Console** | https://portofolio-anyx.onrender.com/console/access |
| **Email** | admin@portofolio-anyx.com |
| **Password** | YourSecurePassword123! |

---

## 🔧 Optional: Prevent Sleep (3 menit)

Render free tier sleep after 15 min. Setup auto-ping:

1. Buka https://cron-job.org
2. Sign up gratis
3. **Create new:**
   - **Title:** Keep Portofolio Awake
   - **URL:** https://portofolio-anyx.onrender.com
   - **Interval:** Every 14 minutes
   - **Enabled:** Yes
4. **Save**

App akan selalu awake 24/7! ✅

---

## 🐛 Troubleshooting

### Build Failed - "could not find driver (pgsql)"
✅ **SOLVED** - nixpacks.toml sudah include `pdo_pgsql`

### Connection Refused
- Verify all DB env vars di Render match Supabase
- Check `DB_SSLMODE=require` ada
- Verify `@17082003Yaudah` password benar

### 500 Error
- Check logs: **Logs tab** di Render
- Run: `php artisan config:cache`
- Check `.env` values

### Admin Login Tidak Bisa
- Ensure `php artisan migrate --force` ran completely
- Re-create admin:
  ```bash
  php artisan tinker
  App\Models\User::where('email', 'admin@portofolio-anyx.com')->delete();
  # Then create again
  ```

---

## 📊 What Got Deployed

| Component | Status |
|-----------|--------|
| **App** | Render (PHP free) |
| **Database** | Supabase PostgreSQL (unlimited) |
| **Storage** | Cloudinary (images) |
| **Auto-deploy** | GitHub integration ✅ |
| **SSL/HTTPS** | Auto ✅ |
| **Backups** | Supabase auto-backup daily ✅ |

---

## 🔄 Auto-Deploy in Future

Setiap push ke GitHub, Render auto-deploy:

```bash
git add .
git commit -m "Update feature"
git push origin main
# Render auto-deploy dalam 2-3 menit
```

---

## 📱 Mobile Testing

App sudah responsive! Test di:
- https://portofolio-anyx.onrender.com (desktop)
- https://portofolio-anyx.onrender.com (mobile)

---

## 💡 Pro Tips

1. **Change Admin Password:**
   ```bash
   php artisan tinker
   $user = App\Models\User::first();
   $user->password = bcrypt('new-password');
   $user->save();
   ```

2. **Monitor App:**
   - Render Logs: Real-time error logs
   - Supabase Console: Database queries
   - Cloudinary Dashboard: Image stats

3. **Update Code:**
   ```bash
   git push origin main
   # Auto-deploy in 2-3 min
   ```

4. **Custom Domain:**
   - Service → Settings → Custom Domain
   - Point DNS CNAME to Render domain
   - SSL auto-provision (5-10 min)

---

## 📞 Support

- **Render Issues:** https://render.com/docs
- **Supabase Issues:** https://supabase.io/docs
- **Laravel Issues:** https://laravel.com/docs

---

**🎉 CONGRATS! Your portfolio is LIVE and FREE FOREVER!**

**Next:** Setup custom domain, add more projects, optimize performance! 🚀
