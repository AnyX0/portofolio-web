#!/bin/bash

# 🚀 Automated Deployment Script untuk Portofolio Anyx
# Setup otomatis ke GitHub dan Render

set -e  # Exit jika ada error

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "🚀 PORTOFOLIO ANYX - AUTOMATED DEPLOYMENT"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""

# Step 1: Check git status
echo "📋 Step 1: Checking Git Status..."
git status
echo ""

# Step 2: Add all files
echo "📝 Step 2: Adding files to git..."
git add .
echo "✅ Files added"
echo ""

# Step 3: Commit
echo "💬 Step 3: Creating commit..."
COMMIT_MSG="Setup Supabase PostgreSQL + Render deployment - portofolio-anyx"
git commit -m "$COMMIT_MSG"
echo "✅ Committed: $COMMIT_MSG"
echo ""

# Step 4: Push to GitHub
echo "🔄 Step 4: Pushing to GitHub..."
git push origin main
echo "✅ Pushed to GitHub main branch"
echo ""

# Step 5: Generate APP_KEY for Render
echo "🔑 Step 5: Generating APP_KEY..."
APP_KEY=$(php artisan key:generate --show)
echo "Generated APP_KEY: $APP_KEY"
echo ""

# Step 6: Display next steps
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "✅ GIT PUSH COMPLETE!"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""
echo "📌 NEXT STEPS (Manual di Render):"
echo ""
echo "1️⃣  Go to: https://render.com"
echo "2️⃣  Dashboard → New + → Web Service"
echo "3️⃣  Connect: project_uas repository"
echo "4️⃣  Name: portofolio-anyx"
echo "5️⃣  Region: Singapore"
echo "6️⃣  Plan: Free"
echo "7️⃣  Click 'Create Web Service'"
echo ""
echo "📋 ENVIRONMENT VARIABLES (Copy-paste ke Render):"
echo ""
cat << 'EOF'
APP_NAME=Portofolio Anyx
APP_ENV=production
APP_DEBUG=false
APP_URL=https://portofolio-anyx.onrender.com
APP_KEY=BASE64_VALUE_HERE
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
CLOUDINARY_API_SECRET=YOUR_SECRET_HERE
CLOUDINARY_UPLOAD_PRESET=portofolio_anyx
SESSION_DRIVER=file
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
LOG_CHANNEL=stack
LOG_LEVEL=error
EOF

echo ""
echo "⚠️  REPLACE 'BASE64_VALUE_HERE' dengan:"
echo "$APP_KEY"
echo ""
echo "⏰ Build akan berjalan 2-3 menit"
echo "✅ Setelah build selesai, buka Shell tab"
echo ""
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
