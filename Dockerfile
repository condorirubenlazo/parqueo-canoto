# Paso 1: Usamos la imagen oficial de PHP 8.2 con Apache
FROM php:8.2-apache

# Paso 2: Instalamos las dependencias y extensiones de PHP que Laravel necesita
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install \
    pdo_mysql \
    pdo_pgsql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    opcache \
    xml

# Paso 3: Instalamos Composer (el gestor de paquetes de PHP)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Paso 4: Establecemos el directorio de trabajo
WORKDIR /var/www/html

# Paso 5: Copiamos los archivos de nuestra aplicación
COPY . .

# Paso 6: Instalamos las dependencias de Laravel
RUN composer install --no-interaction --no-dev --prefer-dist --optimize-autoloader

# Paso 7: Ajustamos permisos
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# Paso 8: Copiamos el .env y generamos la clave
RUN cp .env.example .env
RUN php artisan key:generate

# Paso 9: Limpiamos cachés para producción
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache
