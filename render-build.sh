#!/bin/bash
set -e

echo "Running render-build.sh script..."

# Copy .env.render to .env
echo "Copying .env.render to .env"
cp src/.env.render src/.env

# Install dependencies
echo "Installing dependencies"
cd src
composer install --no-dev --optimize-autoloader
composer require --no-interaction fakerphp/faker

# Generate key if not already set
php artisan key:generate --force

# Make sure we have the bootstrap/app.php with middleware configuration
mkdir -p bootstrap
cat > bootstrap/app.php << 'EOF'
<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\VerifyCsrfToken;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            VerifyCsrfToken::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
EOF

echo "bootstrap/app.php updated with VerifyCsrfToken middleware"

# Make sure VerifyCsrfToken middleware exists
mkdir -p app/Http/Middleware
if [ ! -f "app/Http/Middleware/VerifyCsrfToken.php" ]; then
    echo "Creating VerifyCsrfToken.php"
    cat > app/Http/Middleware/VerifyCsrfToken.php << 'EOF'
<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        // Якщо ви маєте API маршрути, ви можете їх тут виключити
        // 'api/*'
    ];
}
EOF
fi

# Clear Laravel caches
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Create storage symlink
php artisan storage:link

# Publish Livewire assets
php artisan vendor:publish --force --tag=livewire:assets

echo "Build completed successfully" 