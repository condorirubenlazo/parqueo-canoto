# Usamos una imagen moderna optimizada para Laravel
FROM aiiro/laravel-base:8.2-apache

# Establecemos el directorio de trabajo
WORKDIR /var/www/html

# Copiamos primero los archivos de dependencias para optimizar la construcción
COPY composer.json composer.lock ./
RUN composer install --no-interaction --no-dev --prefer-dist --optimize-autoloader

# Ahora copiamos el resto del código de la aplicación
COPY . .

# CORRECCIÓN DE PERMISOS DEFINITIVA:
# En lugar de 'chown', usamos 'chmod' para dar permisos de escritura. Esto es compatible con Render.
RUN chmod -R 775 storage bootstrap/cache

# Copiamos el .env y generamos la clave
RUN cp .env.example .env
RUN php artisan key:generate

# Limpiamos cachés para producción
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache
