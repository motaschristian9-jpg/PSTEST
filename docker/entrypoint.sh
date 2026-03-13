#!/usr/bin/env bash
set -e

# Start PHP-FPM in the background
php-fpm -D

# Run migrations (Optional: better to do this in a CI/CD or build step, but for simplicity here)
# php artisan migrate --force

# Start Nginx in the foreground
nginx -g "daemon off;"
