#!/bin/bash

# 🚀 Automated Post-Deployment Script untuk Render Shell
# Jalankan di Render Shell setelah build selesai

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "🚀 PORTOFOLIO ANYX - POST-DEPLOYMENT SETUP"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""

# Step 1: Run migrations
echo "📦 Step 1: Running database migrations..."
php artisan migrate --force
echo "✅ Migrations completed"
echo ""

# Step 2: Create admin user
echo "👤 Step 2: Creating admin user..."
php artisan tinker << 'EOF'
$admin = new App\Models\User;
$admin->name = 'Admin Anyx';
$admin->email = 'admin@portofolio-anyx.com';
$admin->password = bcrypt('YourSecurePassword123!');
$admin->save();
echo "✅ Admin user created successfully!\n";
exit
EOF
echo ""

# Step 3: Cache optimization
echo "⚡ Step 3: Optimizing cache..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo "✅ Cache optimized"
echo ""

# Step 4: Verify database
echo "✔️  Step 4: Verifying database..."
php artisan tinker << 'EOF'
echo "Database connection: " . DB::connection()->getDatabaseName() . "\n";
echo "Users count: " . App\Models\User::count() . "\n";
echo "Projects count: " . App\Models\Project::count() . "\n";
exit
EOF
echo ""

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "✅ DEPLOYMENT COMPLETE!"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""
echo "🎉 YOUR APP IS LIVE!"
echo ""
echo "📍 Access:"
echo "   URL: https://portofolio-anyx.onrender.com"
echo "   Console: https://portofolio-anyx.onrender.com/console/access"
echo ""
echo "👤 Login:"
echo "   Email: admin@portofolio-anyx.com"
echo "   Password: YourSecurePassword123!"
echo ""
echo "🔄 Next: Setup cron-job.org to prevent sleep (optional)"
echo ""
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
