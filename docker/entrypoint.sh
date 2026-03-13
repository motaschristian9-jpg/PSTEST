#!/bin/sh
set -e

# Start PHP-FPM in the background
php-fpm -D

# Run migrations and seeders
php artisan migrate --seed --force

# Start Nginx in the foreground
nginx -g "daemon off;"
