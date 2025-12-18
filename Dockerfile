FROM php:8.3-cli

# System dependencies + PostgreSQL dev
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN chown -R www-data:www-data /var/www


EXPOSE 8000

CMD php artisan migrate --force \
    && php artisan db:seed --force \
    && php artisan roles:permissions \
    && php artisan permission:cache-reset \
    && php artisan config:clear \
    && php artisan cache:clear \
    && php artisan route:clear \
    && php artisan view:clear \
    && php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
