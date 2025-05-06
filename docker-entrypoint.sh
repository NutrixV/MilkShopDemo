#!/bin/sh
set -e

if [ -d "/app/src" ]; then
  APP_DIR="/app/src"
else
  APP_DIR="/var/www/src"
fi

# Clear Laravel caches
cd $APP_DIR
echo "Working in directory: $APP_DIR"
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Publish Livewire assets
echo "Publishing Livewire assets..."
php artisan vendor:publish --force --tag=livewire:assets

# Wait for PostgreSQL to be available
echo "Checking PostgreSQL connection..."
max_retries=10
retries=0
until PGPASSWORD=$DB_PASSWORD psql -h $DB_HOST -U $DB_USERNAME -d $DB_DATABASE -c "select 1" > /dev/null 2>&1 || [ $retries -eq $max_retries ]; do
  echo "Waiting for PostgreSQL server, retry $retries/$max_retries..."
  sleep 5
  retries=$((retries+1))
done

if [ $retries -eq $max_retries ]; then
  echo "Error: Could not connect to PostgreSQL. Using cached data if available."
else
  echo "PostgreSQL connection successful!"
  php artisan migrate --force
  php artisan db:seed --force || true
fi

if [ "$APP_ENV" = "production" ]; then
  echo "Running in PRODUCTION mode..."
  php artisan optimize
  php artisan config:cache
  php artisan route:cache
  
  if [ -d "/app" ] && [ -n "$PORT" ]; then
    echo "Starting PHP server on port $PORT for Render.com..."
    cd $APP_DIR/public
    exec php -S 0.0.0.0:$PORT
  fi
else
  echo "Running in LOCAL mode..."
  php artisan optimize:clear
fi

exec "$@" 