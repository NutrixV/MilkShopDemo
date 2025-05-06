web: cd src && php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
worker: cd src && php artisan queue:work --tries=3 