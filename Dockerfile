# --- Stage 1: Build Stage ---
FROM php:8.3-fpm-alpine AS builder

WORKDIR /app

# Der Trick: Wir kopieren mit Wildcard. 
# Wenn composer.lock nicht existiert, kopiert er nur die json ohne Fehler.
COPY composer.json composer.loc[k] ./

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Wenn keine Lock-Datei da ist, muss Composer die Abhängigkeiten berechnen.
# Das braucht mehr RAM – behalte deine 12GB im Auge!
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --no-interaction

COPY . .
RUN composer dump-autoload --optimize --no-dev --classmap-authoritative

# --- Stage 2: Production Stage ---
FROM php:8.3-fpm-alpine

RUN apk add --no-cache nginx supervisor \
    && docker-php-ext-install opcache \
    && mkdir -p /var/log/supervisor /var/run/nginx /var/www/html

WORKDIR /var/www/html

COPY docker/nginx.conf /etc/nginx/http.d/default.conf
COPY docker/supervisord.conf /etc/supervisord.conf

# Holen der Daten aus der Build-Stage
COPY --from=builder /app /var/www/html

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

EXPOSE 80

CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisord.conf"]