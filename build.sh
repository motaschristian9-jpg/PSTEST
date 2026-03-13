#!/usr/bin/env bash
# Exit on error
set -e

echo "--- Installing Dependencies ---"
composer install --no-dev --optimize-autoloader

echo "--- Building Assets ---"
npm install
npm run build

echo "--- Optimizing Laravel ---"
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "--- Running Migrations ---"
php artisan migrate --force

echo "--- Deployment Complete ---"
