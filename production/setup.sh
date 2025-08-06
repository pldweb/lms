#!/bin/bash
# Hentikan script jika ada perintah yang gagal
set -e

# --- KONFIGURASI (SESUAIKAN INI) ---
DOMAIN="lms-smpn-20.my.id"
PROJECT_PATH="/var/www/lms-backend"
PHP_VERSION="8.4" # Ganti dengan versi PHP Anda (contoh: 8.2, 8.3)
# --- AKHIR KONFIGURASI ---

echo "🚀 Memulai setup server untuk domain: $DOMAIN..."

# 1. Update server dan install software yang dibutuhkan
echo "Menginstall Nginx, Certbot, dan dependensi..."
sudo apt-get update
sudo apt-get install -y nginx curl git
sudo apt-get install -y python3-certbot-nginx

# 2. Install Composer
if ! command -v composer &> /dev/null
then
    echo "Composer tidak ditemukan. Menginstall Composer..."
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    php composer-setup.php
    php -r "unlink('composer-setup.php');"
    sudo mv composer.phar /usr/local/bin/composer
else
    echo "Composer sudah terinstall."
fi

# 3. Buat file konfigurasi Nginx
echo "Membuat file konfigurasi Nginx..."
NGINX_CONF="/etc/nginx/sites-available/$DOMAIN"

sudo tee $NGINX_CONF > /dev/null <<EOF
server {
    listen 80;
    listen [::]:80;

    server_name $DOMAIN www.$DOMAIN;
    root $PROJECT_PATH/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php index.html index.htm;

    charset utf-8;

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php$PHP_VERSION-fpm.sock;
        fastcgi_param SCRIPT_FILENAME \$realpath_root\$fastcgi_script_name;
        fastcgi_param DOCUMENT_ROOT \$realpath_root;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
EOF

# 4. Aktifkan site Nginx
echo "Mengaktifkan site Nginx..."
sudo ln -sfn $NGINX_CONF /etc/nginx/sites-enabled/
sudo rm -f /etc/nginx/sites-enabled/default

# 5. Uji konfigurasi Nginx dan reload
echo "Reload Nginx..."
sudo nginx -t
sudo systemctl reload nginx

# 6. Generate SSL Certificate dengan Certbot
echo "Menjalankan Certbot untuk men-generate SSL..."
# Ganti dengan email Anda untuk notifikasi SSL
sudo certbot --nginx -d $DOMAIN -d www.$DOMAIN --non-interactive --agree-tos -m admin@$DOMAIN

echo "✅ Setup server selesai! Proyek siap untuk di-clone dan di-deploy."