# Usamos una imagen oficial de PHP con Composer y Node.js
FROM thecodingmachine/php:8.2-v4-apache

# Copiamos el código de nuestra aplicación al contenedor
COPY . /var/www/html/

# Establecemos los permisos correctos
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Cambiamos al directorio de la aplicación
WORKDIR /var/www/html

# Instalamos las dependencias de Composer
RUN composer install --no-interaction --no-plugins --no-scripts --no-dev --prefer-dist --optimize-autoloader

# Copiamos el archivo de entorno y generamos la clave
RUN cp .env.example .env
RUN php artisan key:generate

# Compilamos los assets (si los tuvieras, no hace daño tenerlo)
# RUN npm install && npm run build

# Limpiamos cachés para producción
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

# Exponemos el puerto 80
EXPOSE 80