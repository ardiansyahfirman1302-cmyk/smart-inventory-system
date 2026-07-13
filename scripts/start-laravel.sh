#!/bin/bash
# Wait for MariaDB socket to be ready, then start Laravel dev server.
set -e

TIMEOUT=60
COUNT=0
while [ ! -S /var/run/mysqld/mysqld.sock ] && [ $COUNT -lt $TIMEOUT ]; do
    sleep 1
    COUNT=$((COUNT + 1))
done

if [ ! -S /var/run/mysqld/mysqld.sock ]; then
    echo "[laravel] MariaDB socket did not appear within ${TIMEOUT}s. Continuing anyway..."
fi

# Ensure DB + user exist (idempotent). Uses unix_socket root auth.
mysql --socket=/var/run/mysqld/mysqld.sock <<'SQL' >/dev/null 2>&1 || true
CREATE DATABASE IF NOT EXISTS smart_inventory CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS 'laravel'@'127.0.0.1' IDENTIFIED BY 'laravel_password';
GRANT ALL PRIVILEGES ON smart_inventory.* TO 'laravel'@'127.0.0.1';
FLUSH PRIVILEGES;
SQL

cd /app

# Run migrations + seed if pending (safe / idempotent)
php artisan migrate --force >/dev/null 2>&1 || true

# Seed once - if there are no users, run seeder
USER_COUNT=$(php artisan tinker --execute="echo App\Models\User::count();" 2>/dev/null | tail -n1 | tr -d '[:space:]')
if [ "$USER_COUNT" = "0" ] || [ -z "$USER_COUNT" ]; then
    php artisan db:seed --force >/dev/null 2>&1 || true
fi

exec php artisan serve --host=0.0.0.0 --port="${LARAVEL_PORT:-3000}"
