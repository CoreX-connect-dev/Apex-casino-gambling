FROM php:8.2-cli AS vendor

RUN apt-get update && apt-get install -y unzip git \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app
COPY composer.json composer.lock ./
RUN mkdir -p database/seeds database/seeders database/factories database/migrations \
    && composer install --no-dev --optimize-autoloader --no-interaction --no-scripts --ignore-platform-reqs

FROM dunglas/frankenphp:php8.2-bookworm

RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev libzip-dev libonig-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring gd zip bcmath opcache

WORKDIR /app

COPY --from=vendor /app/vendor ./vendor
COPY . .

RUN mkdir -p storage/framework/{sessions,views,cache,testing} storage/logs bootstrap/cache \
    && chmod -R a+rw storage bootstrap/cache \
    && mkdir -p database/seeds database/seeders database/factories database/migrations

EXPOSE 80

RUN echo 'APP_NAME=ApexBet\nAPP_ENV=production\nAPP_KEY=base64:X4Y7mK9pQrN2vL8wJ3hF6tA1sE5uC0dG\nAPP_DEBUG=false\nAPP_URL=https://apex-casino-gambling-production.up.railway.app\nDB_CONNECTION=mysql\nDB_HOST=reseau.proxy.rlwy.net\nDB_PORT=57029\nDB_DATABASE=railway\nDB_USERNAME=root\nDB_PASSWORD=RCPLfoFNdCDVnFmrovpRPqsXXaruwLgF\nCACHE_DRIVER=file\nSESSION_DRIVER=file\nQUEUE_CONNECTION=sync' > /app/.env

CMD ["sh", "-c", "php artisan config:cache && php artisan route:cache && frankenphp run --config /app/Caddyfile"]
