# Paso 1: Usamos la imagen oficial de PHP 8.2 con Apache, que es universalmente compatible
FROM php:8.2-apache

# Paso 2: Instalamos las herramientas básicas y las extensiones de PHP para Laravel y Postgres
RUN apt-get update && apt-get install -y git unzip zip libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Paso 3: Instalamos Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Paso 4: Establecemos el directorio de trabajo
WORKDIR /var/www/html

# Paso 5: Copiamos el código de la aplicación
COPY . .

# Paso 6: Instalamos las dependencias de Laravel
RUN composer install --no-dev --optimize-autoloader

# Paso 7: Preparamos el archivo .env y generamos la clave
RUN cp .env.example .env
RUN php artisan key:generate

# Paso 8: Limpiamos cachés para producción
RUN php artisan config:cache

# Paso 9: ¡EL COMANDO DE LA VICTORIA!
# Iniciamos el servidor en el puerto que Zeabur nos asigne a través de la variable $PORT
CMD php artisan serve --host=0.0.0.0 --port=${PORT}
