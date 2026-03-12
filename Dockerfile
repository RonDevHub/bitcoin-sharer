FROM php:8.3-fpm-alpine

# Installiere System-Abhängigkeiten und PHP-Erweiterungen
RUN apk add --no-cache nginx supervisor \
    && docker-php-ext-install opcache

# Composer installieren
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Arbeitsverzeichnis
WORKDIR /var/www/html

# Nginx Konfiguration (No Logs!)
COPY docker/nginx.conf /etc/nginx/http.d/default.conf

# App-Dateien kopieren
COPY . .

# Abhängigkeiten installieren
RUN composer install --no-dev --optimize-autoloader

# Rechte setzen
RUN chown -R www-data:www-data /var/www/html

# Supervisor für Nginx & PHP-FPM
COPY docker/supervisord.conf /etc/supervisord.conf

EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]