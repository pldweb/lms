#!/bin/bash

# Script untuk menginstall semua kebutuhan server untuk aplikasi Laravel
# Dibuat untuk LMS SMPN 20

echo "=== Memulai setup server untuk aplikasi LMS SMPN 20 ==="

# Memastikan script dijalankan sebagai root
if [ "$(id -u)" != "0" ]; then
   echo "Script ini harus dijalankan sebagai root" 1>&2
   exit 1
fi

# Update repository
echo "=== Updating repository ==="
apt update
apt upgrade -y

# Install paket dasar yang dibutuhkan
echo "=== Menginstall paket dasar ==="
apt install -y curl wget git unzip software-properties-common apt-transport-https ca-certificates gnupg

# Install Nginx
echo "=== Menginstall Nginx ==="
apt install -y nginx
systemctl enable nginx
systemctl start nginx

# Install MySQL
echo "=== Menginstall MySQL ==="
apt install -y mysql-server
systemctl enable mysql
systemctl start mysql

# Konfigurasi MySQL untuk keamanan
echo "=== Mengkonfigurasi MySQL ==="
mysql_secure_installation

# Membuat database untuk aplikasi
echo "=== Membuat database untuk aplikasi ==="
echo "Masukkan password root MySQL:"
read -s rootpasswd

mysql -u root -p"${rootpasswd}" -e "CREATE DATABASE IF NOT EXISTS lms_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
mysql -u root -p"${rootpasswd}" -e "CREATE USER IF NOT EXISTS 'lms_user'@'localhost' IDENTIFIED BY 'lms_password';"
mysql -u root -p"${rootpasswd}" -e "GRANT ALL PRIVILEGES ON lms_db.* TO 'lms_user'@'localhost';"
mysql -u root -p"${rootpasswd}" -e "FLUSH PRIVILEGES;"

# Install PHP 8.3 dan ekstensi yang dibutuhkan
echo "=== Menginstall PHP 8.3 dan ekstensi ==="
add-apt-repository -y ppa:ondrej/php
apt update

apt install -y php8.3 php8.3-fpm php8.3-cli php8.3-common php8.3-mysql php8.3-zip php8.3-gd php8.3-mbstring php8.3-curl php8.3-xml php8.3-bcmath php8.3-intl php8.3-readline php8.3-ldap php8.3-soap

systemctl enable php8.3-fpm
systemctl start php8.3-fpm

# Install Composer
echo "=== Menginstall Composer ==="
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Konfigurasi Nginx untuk aplikasi Laravel
echo "=== Mengkonfigurasi Nginx untuk aplikasi Laravel ==="
cat > /etc/nginx/sites-available/lms << 'EOL'
server {
    listen 80;
    server_name smpn20.rinkwebstudio.com;
    root /var/www/lms/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-XSS-Protection "1; mode=block";
    add_header X-Content-Type-Options "nosniff";

    index index.html index.htm index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
EOL

ln -s /etc/nginx/sites-available/lms /etc/nginx/sites-enabled/
rm -f /etc/nginx/sites-enabled/default

# Install Certbot untuk SSL
echo "=== Menginstall Certbot untuk SSL ==="
apt install -y certbot python3-certbot-nginx

# Restart Nginx
systemctl restart nginx

# Membuat direktori untuk aplikasi
echo "=== Menyiapkan direktori aplikasi ==="
mkdir -p /var/www/lms

# Menambahkan entri ke /etc/hosts
echo "=== Menambahkan entri ke /etc/hosts ==="
echo "127.0.0.1 smpn20.rinkwebstudio.com" >> /etc/hosts

# Instruksi untuk deployment aplikasi
echo ""
echo "=== Setup server selesai! ==="
echo ""
echo "Untuk menyelesaikan deployment aplikasi, lakukan langkah berikut:"
echo "1. Salin kode aplikasi ke /var/www/lms"
echo "2. Masuk ke direktori aplikasi: cd /var/www/lms"
echo "3. Salin .env.example ke .env: cp .env.example .env"
echo "4. Edit file .env dan sesuaikan konfigurasi database:"
echo "   DB_DATABASE=lms_db"
echo "   DB_USERNAME=lms_user"
echo "   DB_PASSWORD=lms_password"
echo "5. Install dependensi: composer install"
echo "6. Generate application key: php artisan key:generate"
echo "7. Jalankan migrasi database: php artisan migrate --seed"
echo "8. Atur permission: chown -R www-data:www-data /var/www/lms"
echo "9. Akses aplikasi di browser: http://smpn20.rinkwebstudio.com"
echo "10. Untuk mengaktifkan SSL, jalankan perintah berikut:"
echo "    sudo certbot --nginx -d smpn20.rinkwebstudio.com"
echo "    Ikuti petunjuk yang diberikan oleh Certbot"
echo ""
echo "Selamat, server Anda siap digunakan!"