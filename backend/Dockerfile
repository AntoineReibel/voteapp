# backend/Dockerfile
FROM php:8.2-fpm-alpine

# Installer les extensions PHP nécessaires
RUN docker-php-ext-install pdo pdo_mysql

# Installer Nginx
RUN apk add --no-cache nginx

# Créer les répertoires nécessaires
RUN mkdir -p /var/www/html /run/nginx

# Copier les fichiers PHP
COPY api/ /var/www/html/api/

# Copier la configuration Nginx
COPY nginx-backend.conf /etc/nginx/http.d/default.conf

# Copier le script de démarrage
COPY start.sh /start.sh
RUN chmod +x /start.sh

# Donner les permissions
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80

CMD ["/start.sh"]