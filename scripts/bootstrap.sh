#!/bin/bash
# Smart Inventory AI - Bootstrap Script
# Ensures PHP, Composer, and MariaDB are installed and running.
# Idempotent: safe to run repeatedly.

set -e

LOG=/var/log/supervisor/bootstrap.log
mkdir -p /var/log/supervisor
exec > >(tee -a "$LOG") 2>&1

echo "[$(date)] === Bootstrap start ==="

# ---------- PHP ----------
if ! command -v php >/dev/null 2>&1; then
    echo "[bootstrap] Installing PHP 8.2 + extensions..."
    export DEBIAN_FRONTEND=noninteractive
    apt-get update -qq
    apt-get install -y --no-install-recommends \
        php8.2 php8.2-cli php8.2-fpm php8.2-mbstring php8.2-xml \
        php8.2-mysql php8.2-sqlite3 php8.2-curl php8.2-zip \
        php8.2-bcmath php8.2-gd php8.2-tokenizer php8.2-common \
        unzip >/dev/null 2>&1
    echo "[bootstrap] PHP installed: $(php -v | head -1)"
else
    echo "[bootstrap] PHP already installed: $(php -v | head -1)"
fi

# ---------- Composer ----------
if ! command -v composer >/dev/null 2>&1; then
    echo "[bootstrap] Installing Composer..."
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer >/dev/null 2>&1
    echo "[bootstrap] Composer installed: $(composer --version)"
else
    echo "[bootstrap] Composer already installed."
fi

# ---------- MariaDB ----------
if ! command -v mariadbd >/dev/null 2>&1; then
    echo "[bootstrap] Installing MariaDB..."
    export DEBIAN_FRONTEND=noninteractive
    apt-get update -qq
    apt-get install -y --no-install-recommends mariadb-server mariadb-client >/dev/null 2>&1
    echo "[bootstrap] MariaDB installed."
fi

# Init data dir if missing
if [ ! -d /var/lib/mysql/mysql ]; then
    echo "[bootstrap] Initializing MariaDB data directory..."
    mariadb-install-db --user=mysql --datadir=/var/lib/mysql >/dev/null 2>&1 || true
fi

mkdir -p /var/run/mysqld
chown -R mysql:mysql /var/run/mysqld /var/lib/mysql

# ---------- App Vendor / DB Ready Marker ----------
cd /app

if [ ! -d /app/vendor ]; then
    echo "[bootstrap] Running composer install..."
    composer install --no-interaction --optimize-autoloader >/dev/null 2>&1
fi

if [ ! -d /app/public/build ]; then
    echo "[bootstrap] Building Vite assets..."
    npm install --silent >/dev/null 2>&1
    npm run build >/dev/null 2>&1
fi

echo "[$(date)] === Bootstrap complete ==="
exit 0
