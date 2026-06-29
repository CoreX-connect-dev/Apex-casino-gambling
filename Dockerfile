FROM php:8.2-cli AS vendor
RUN apt-get update && apt-get install -y unzip git \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
WORKDIR /app
COPY composer.json composer.lock ./
RUN mkdir -p database/seeds database/seeders database/factories database/migrations \
    && composer install --no-dev --optimize-autoloader --no-interaction --no-scripts --ignore-platform-reqs

FROM dunglas/frankenphp:php8.2-bookworm
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev libzip-dev libonig-dev nodejs npm \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring gd zip bcmath opcache

WORKDIR /app
COPY --from=vendor /app/vendor ./vendor
COPY . .

RUN npm install && npm run production

# Fix corrupted JS files
RUN curl -o /app/public/frontend/Default/js/jquery-3.4.1.min.js https://code.jquery.com/jquery-3.4.1.min.js
RUN curl -o /app/public/woocasino/js/angular.min.js https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js
RUN curl -o /app/public/woocasino/js/angular-lazy-img.min.js https://cdn.jsdelivr.net/npm/angular-lazy-img@0.3.3/release/angular-lazy-img.min.js
RUN curl -o /app/public/woocasino/js/sweetalert.min.js https://cdn.jsdelivr.net/npm/sweetalert@2.1.2/dist/sweetalert.min.js
RUN curl -o /app/public/woocasino/js/perfect-scrollbar.jquery.js https://cdn.jsdelivr.net/npm/perfect-scrollbar@0.8.1/dist/js/perfect-scrollbar.jquery.min.js
RUN curl -o /app/public/woocasino/js/jquery-1.7.1.min.js https://code.jquery.com/jquery-1.7.1.min.js
RUN curl -o /app/public/woocasino/js/respond.min.js https://cdn.jsdelivr.net/npm/respond.js@1.4.2/dest/respond.min.js
RUN curl -o /app/public/woocasino/js/html5shiv.min.js https://cdn.jsdelivr.net/npm/html5shiv@3.7.3/dist/html5shiv.min.js
RUN curl -o /app/public/woocasino/js/zebra_datepicker.min.js https://cdn.jsdelivr.net/npm/zebra_datepicker/dist/zebra_datepicker.min.js

RUN mkdir -p storage/framework/{sessions,views,cache,testing} storage/logs bootstrap/cache \
    && chmod -R a+rw storage bootstrap/cache \
    && mkdir -p database/seeds database/seeders database/factories database/migrations

RUN printf 'APP_NAME=ApexBet\nAPP_ENV=production\nAPP_KEY=base64:JtqUpV4rrhTFxtLbFGwVMMpCuKYEY/vX3sf7rF8ZGBA=\nAPP_DEBUG=false\nAPP_URL=https://apex-casino-gambling-production.up.railway.app\nDB_CONNECTION=mysql\nDB_HOST=reseau.proxy.rlwy.net\nDB_PORT=57029\nDB_DATABASE=railway\nDB_USERNAME=root\nDB_PASSWORD=RCPLfoFNdCDVnFmrovpRPqsXXaruwLgF\nCACHE_DRIVER=file\nSESSION_DRIVER=file\nQUEUE_CONNECTION=sync\n' > /app/.env

EXPOSE 80

CMD ["sh", "-c", "php artisan config:cache && php artisan route:cache && frankenphp run --config /app/Caddyfile"]
