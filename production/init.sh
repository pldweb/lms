#!/bin/bash
# Hentikan script jika ada perintah yang gagal
set -e

# --- KONFIGURASI (SESUAIKAN INI) ---
GIT_REPO_URL="https://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@github.com/pldweb/lms.git"
PROJECT_PATH="/var/www/lms-backend"
# --- AKHIR KONFIGURASI ---

echo "🚀 Memulai inisialisasi proyek Laravel..."

# 1. Clone repository dari GitHub
echo "Melakukan clone dari repository..."
git clone $GIT_REPO_URL $PROJECT_PATH

# 2. Masuk ke direktori proyek
cd $PROJECT_PATH

# 3. Salin template .env
echo "Menyalin .env.example ke .env..."
cp .env.example .env

# 4. Install dependensi Composer
echo "Install dependensi Composer..."
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# 5. Generate Application Key
echo "Generate APP_KEY..."
php artisan key:generate

# 6. Buat symbolic link untuk storage
echo "Membuat storage link..."
php artisan storage:link

# 7. Jalankan migrasi dan seeder awal
echo "Menjalankan migrasi dan seeder awal..."
php artisan app:start-seeder

# 8. Atur kepemilikan dan izin folder
echo "Mengatur izin folder..."
sudo chown -R $USER:www-data .
sudo chmod -R 775 storage bootstrap/cache

# 9. Buat cache optimasi
echo "Membuat cache optimasi..."
php artisan app:clear-route

echo "✅ Inisialisasi proyek selesai!"
echo "‼️ PENTING: Jangan lupa untuk mengedit file .env dan mengisi semua nilai yang kosong (seperti password database)."
nano .env