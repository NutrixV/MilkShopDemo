FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpq-dev \
    unzip \
    libzip-dev \
    zip \
    libicu-dev \
    postgresql-client \
    && docker-php-ext-install pdo pdo_pgsql zip pcntl \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl

# Install Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy application files
COPY ./src /var/www/src

# Create base .env file if it doesn't exist
RUN if [ ! -f "/var/www/src/.env" ]; then cp /var/www/src/.env.example /var/www/src/.env || echo "APP_KEY=" > /var/www/src/.env; fi

RUN cd src && composer install

# Set permissions
RUN chown -R www-data:www-data /var/www/src
RUN chmod -R 775 /var/www/src/storage /var/www/src/bootstrap/cache

# Create symlinks
RUN cd src && php artisan storage:link

# Expose port for PHP-FPM
EXPOSE 9000

COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh
ENTRYPOINT ["docker-entrypoint.sh"]

# CMD for PHP-FPM
CMD ["php-fpm"] 