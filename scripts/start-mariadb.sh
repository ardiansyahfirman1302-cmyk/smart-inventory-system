#!/bin/bash
# Wait for MariaDB binary (installed by bootstrap) then start it in foreground.
TIMEOUT=120
COUNT=0
while ! command -v mariadbd >/dev/null 2>&1 && [ $COUNT -lt $TIMEOUT ]; do
    sleep 1
    COUNT=$((COUNT + 1))
done

if ! command -v mariadbd >/dev/null 2>&1; then
    echo "[mariadb-start] mariadbd not available after ${TIMEOUT}s"
    exit 1
fi

mkdir -p /var/run/mysqld
chown -R mysql:mysql /var/run/mysqld /var/lib/mysql 2>/dev/null || true

exec /usr/sbin/mariadbd \
    --user=mysql \
    --datadir=/var/lib/mysql \
    --socket=/var/run/mysqld/mysqld.sock \
    --bind-address=127.0.0.1
