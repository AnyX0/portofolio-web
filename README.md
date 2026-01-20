# 🚀 Portfolio Laravel

Portfolio website dengan Laravel 12, Cloudinary image storage, dan MySQL.

## 🎯 Features

- ✅ Multiple image upload dengan Cloudinary
- ✅ Portfolio project management dengan image galleries
- ✅ Admin console untuk CRUD projects
- ✅ **Live Preview Modal** dengan iframe untuk menampilkan project URL
- ✅ Image slider dengan Swiper.js
- ✅ Image caching (24 jam) untuk performa optimal
- ✅ Responsive design dengan Tailwind CSS
- ✅ AJAX upload dengan progress bar
- ✅ Delete images dari Cloudinary
- ✅ Drag-drop image reordering
- ✅ API endpoint dengan validasi slug dan error handling

## 🛠️ Tech Stack

- **Backend:** Laravel 12.44 (PHP 8.3)
- **Frontend:** Blade Templates, Tailwind CSS v4, Swiper.js
- **Database:** MySQL 8.0 / PostgreSQL (Vercel-compatible)
- **Image Storage:** Cloudinary
- **Hosting:** Vercel (Serverless), Railway, or Clever Cloud

## 📦 Quick Start

### Local Development (Singkat)

```bash
# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Configure database di .env
# DB_DATABASE=portfolio_db
# DB_USERNAME=root
# DB_PASSWORD=

# Run migrations
php artisan migrate

# Build assets
npm run build

# Start server
php artisan serve
```

Visit: http://localhost:8000

### 🖥️ Panduan Localhost (Detail)

1) Prasyarat: PHP 8.3+, Composer, Node 18+, MySQL/PostgreSQL sudah jalan.  
2) Clone & masuk folder proyek.  
3) Salin env dan set kunci:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4) Set di .env untuk lokal:
   ```env
   APP_NAME="Portfolio Laravel"
   APP_ENV=local
   APP_DEBUG=true
   APP_URL=http://localhost:8000
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=portfolio_db
   DB_USERNAME=root
   DB_PASSWORD=
   # Opsional Cloudinary (isi jika pakai upload gambar)
   CLOUDINARY_CLOUD_NAME=xxx
   CLOUDINARY_API_KEY=xxx
   CLOUDINARY_API_SECRET=xxx
   ```
5) Install dependensi backend & frontend:
   ```bash
   composer install
   npm install
   ```
6) Migrasi + storage link:
   ```bash
   php artisan migrate
   php artisan storage:link
   ```
7) Jalankan dev server (dua terminal terpisah):
   ```bash
   npm run dev      # Vite dev server (hot reload)
   php artisan serve --host=127.0.0.1 --port=8000
   ```
   Akses: http://localhost:8000

8) (Opsional) Build produksi lokal:
   ```bash
   npm run build
   ```

### Admin Access

Console: http://localhost:8000/console/access

Create admin via tinker:
```bash
php artisan tinker
```
```php
$admin = new App\Models\User;
$admin->name = 'Admin';
$admin->email = 'admin@example.com';
$admin->password = bcrypt('password');
$admin->save();
exit
```

## 🚀 Deployment

**📖 Full deployment guide:** [DEPLOYMENT.md](DEPLOYMENT.md)

### Option 1: Vercel (Serverless) ⚡

Deploy full Laravel app dengan serverless PHP di Vercel:

1. **Push ke GitHub** (✅ sudah dilakukan!)
2. **Import di Vercel** → [vercel.com/new](https://vercel.com/new)
3. **Set Environment Variables** di Vercel:
   ```env
   APP_KEY=base64:...  # Generate dengan: php artisan key:generate --show
   APP_ENV=production
   APP_DEBUG=false
   DB_CONNECTION=mysql
   DB_HOST=your-db-host
   DB_DATABASE=your-db-name
   DB_USERNAME=your-db-user
   DB_PASSWORD=your-db-password
   CLOUDINARY_CLOUD_NAME=...
   CLOUDINARY_API_KEY=...
   CLOUDINARY_API_SECRET=...
   ```
4. **Deploy** → Vercel otomatis build & deploy
5. **Run migrations** dari lokal ke DB yang sama:
   ```bash
   php artisan migrate --force
   ```

### Option 2: Railway / Clever Cloud

Detail lengkap tersedia di [DEPLOYMENT.md](DEPLOYMENT.md)

## 📁 Project Structure

```
project_uas/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/
│   │   │   ├── ProjectController.php    # CRUD projects
│   │   │   ├── DashboardController.php  # Admin dashboard
│   │   │   └── UploadController.php     # AJAX upload
│   │   └── PortfolioController.php      # Public portfolio
│   ├── Models/
│   │   └── Project.php
│   └── Services/
│       ├── CloudinaryImageFetcher.php   # Fetch images
│       ├── CloudinaryImageDeleter.php   # Delete images
│       └── CloudinaryUploader.php       # Upload images
├── resources/views/
│   ├── portfolio/
│   │   ├── index.blade.php              # Portfolio listing
│   │   └── show.blade.php               # Project detail
│   └── admin/
│       ├── dashboard.blade.php          # Admin dashboard
│       └── projects/
│           ├── index.blade.php          # Projects list
│           ├── create.blade.php
│           ├── edit.blade.php
│           └── partials/form.blade.php  # Form with AJAX
├── routes/web.php
├── DEPLOYMENT.md                        # 📖 Railway guide
├── Procfile                             # Railway start
└── nixpacks.toml                        # Build config
```

## 🔑 Environment Variables

```env
# App
APP_NAME="Portfolio Laravel"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app.up.railway.app

# Database (Railway auto-generates)
DB_CONNECTION=mysql
DB_HOST=containers-us-west-xxx.railway.app
DB_PORT=3306
DB_DATABASE=railway
DB_USERNAME=root
DB_PASSWORD=auto-generated

# Cloudinary (dari cloudinary.com)
CLOUDINARY_CLOUD_NAME=your_cloud_name
CLOUDINARY_API_KEY=your_api_key
CLOUDINARY_API_SECRET=your_api_secret
CLOUDINARY_UPLOAD_PRESET=your_preset
```

## 📸 Cloudinary Setup

1. Buat account di [cloudinary.com](https://cloudinary.com)
2. Dashboard → Settings → Upload → **Add upload preset**
3. Set **Signing Mode** = **Unsigned**
4. Copy credentials ke `.env`:
   - Cloud name
   - API key
   - API secret
   - Upload preset name

## 🎨 Key Features

### Image Management
- **Multiple upload** dengan preview
- **Progress bar** untuk setiap upload
- **Delete** existing images
- **Drag-drop reorder** slides
- Auto-upload ke folder per-project

### Performance
- **Image caching** (24 jam TTL)
- **Batch fetching** (avoid N+1)
- View/config/route caching
- Optimized queries

### Admin Console
- **Dashboard** dengan stats
- **Projects list** dengan filter
- **AJAX upload** tanpa reload
- **Delete confirmation**

## 📚 Documentation

- **[DEPLOYMENT.md](DEPLOYMENT.md)** - Railway setup lengkap
- [Laravel Docs](https://laravel.com/docs)
- [Cloudinary Docs](https://cloudinary.com/documentation)
- [Railway Docs](https://docs.railway.app)

## 🐛 Troubleshooting

### Images tidak tampil
- Check Cloudinary credentials
- Verify upload preset = **Unsigned**
- Check SSL in CloudinaryImageFetcher

### Upload gagal
- File size < 5MB
- Mime: jpg, jpeg, png, webp
- Check Cloudinary quota

### Database error
```bash
php artisan migrate --force
```

**More:** [DEPLOYMENT.md#troubleshooting](DEPLOYMENT.md#troubleshooting)

## 💡 Tips

### Local Development
```bash
# Clear all caches
php artisan optimize:clear

# Rebuild caches
php artisan optimize

# Watch Tailwind changes
npm run dev
```

### Production
```bash
# Cache everything
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Check logs
tail storage/logs/laravel.log
```

## 🤝 Contributing

1. Fork repository
2. Create branch (`git checkout -b feature/AmazingFeature`)
3. Commit (`git commit -m 'Add feature'`)
4. Push (`git push origin feature/AmazingFeature`)
5. Open Pull Request

## 📄 License

Open-source - MIT License

## 👨‍💻 Author

**Andi**
- Project: Portfolio Laravel
- Course: Pemrograman Mobile - Semester 5
- Year: 2025

---

**🚀 Deploy sekarang!** Baca [DEPLOYMENT.md](DEPLOYMENT.md) untuk guide lengkap Railway + MySQL remote.
