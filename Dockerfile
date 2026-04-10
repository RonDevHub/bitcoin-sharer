FROM php:8.3-fpm-alpine AS builder

WORKDIR /app
COPY composer.json composer.lock ./

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

COPY . .
RUN composer dump-autoload --optimize --no-dev --classmap-authoritative

FROM php:8.3-fpm-alpine

RUN apk add --no-cache nginx supervisor \
    && docker-php-ext-install opcache \
    && mkdir -p /var/log/supervisor /var/run/nginx

WORKDIR /var/www/html

COPY docker/nginx.conf /etc/nginx/http.d/default.conf
COPY docker/supervisord.conf /etc/supervisord.conf

COPY --from=builder /app /var/www/html

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

EXPOSE 80

CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisord.conf"]