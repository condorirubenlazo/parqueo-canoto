# Paso 1: Usamos la imagen oficial de PHP 8.2 con Apache.
# Es una buena base, pero la mayoría de las plataformas de PaaS prefieren un setup FPM con Nginx.
# Si Zeabur detecta Apache, puede que intente usar eso.
# Para Laravel, php:8.2-fpm-alpine con Nginx es más común y eficiente en contenedores.
# Pero si tu setup actual en Zeabur se adapta a Apache, podemos seguir con eso.
FROM php:8.2-apache

# Paso 2: Instalamos las herramientas básicas y las extensiones de PHP para Laravel y Postgres
# Es buena práctica también instalar 'gnupg' y 'libzip-dev' si no están, para Composer y extensiones de zip.
# Asegúrate de que todas las extensiones que tu aplicación Laravel necesita estén aquí.
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libpq-dev \
    # Si vas a usar Apache, a veces necesitas más cosas para mod_rewrite, etc.
    # Pero la imagen php:apache suele venir preconfigurada para un uso básico.
    && docker-php-ext-install pdo pdo_pgsql opcache

# Paso 3: Instalamos Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Paso 4: Establecemos el directorio de trabajo
WORKDIR /var/www/html

# Paso 5: Copiamos el código de la aplicación
# Este paso debe ir después de la instalación de dependencias si estás usando un multistage build
# Pero si copias todo de golpe, asegúrate de que el .env.example exista.
COPY . .

# Paso 6: Instalamos las dependencias de Laravel
# --no-dev es importante para producción, --optimize-autoloader mejora el rendimiento.
RUN composer install --no-dev --optimize-autoloader

# === CÓDIGOS CRÍTICOS PARA PERMISOS ===
# Estas líneas son las que probablemente te estaban dando el error "Operation not permitted"
# Necesitas asegurarte de que el usuario bajo el cual Apache/PHP-FPM se ejecuta
# (generalmente 'www-data' en imágenes Debian/Ubuntu) tenga permisos de escritura
# en los directorios 'storage' y 'bootstrap/cache'.

# Primero, establece los permisos en los directorios
RUN chmod -R 775 storage bootstrap/cache

# Luego, cambia el propietario y grupo a 'www-data'
# www-data es el usuario predeterminado que usa Apache/PHP-FPM en muchas imágenes PHP
RUN chown -R www-data:www-data storage bootstrap/cache

# Paso 7 (AJUSTADO): Eliminar pasos de configuración de .env y key generation aquí.
# Estos deben hacerse como variables de entorno en Zeabur y post-despliegue.
# Elimina: RUN cp .env.example .env
# Elimina: RUN php artisan key:generate

# Paso 8 (AJUSTADO): Limpiamos cachés para producción
# Esto es mejor hacerlo DESPUÉS de que las variables de entorno se hayan cargado en Zeabur.
# Por lo tanto, ¡elimina esta línea de aquí!
# RUN php artisan config:cache
# Lo harás manualmente en la terminal de Zeabur después de desplegar.

# Paso 9: ¡EL COMANDO DE LA VICTORIA!
# Para Apache, es común que la imagen base ya inicie Apache.
# Si estás usando php:8.2-apache, el comando CMD ya está configurado para iniciar Apache.
# Si Laravel se sirve a través del servidor web de desarrollo de Artisan, Zeabur necesita saber cómo iniciarlo.
# Si Zeabur provee un Nginx/Apache que apunta a php-fpm, este CMD no sería necesario o sería `php-fpm`.
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=${PORT}"]

# Si la imagen php:apache ya inicia Apache, este CMD podría no ser necesario,
# o necesitarías sobrescribir el CMD por defecto de la imagen para que Apache apunte
# a tu carpeta 'public' de Laravel. Esto se hace con un archivo .conf en Apache.
# Por ejemplo, si tu proyecto está en /var/www/html y tu 'public' está en /var/www/html/public
# Podrías necesitar:
# COPY 000-default.conf /etc/apache2/sites-available/000-default.conf
# Y dentro de 000-default.conf, ajustar DocumentRoot a /var/www/html/public
# Y luego el CMD podría ser simplemente el comando de inicio de Apache por defecto.

# Sin embargo, por simplicidad y siguiendo el patrón de Zeabur,
# usar 'php artisan serve' es a menudo el camino más fácil si no quieres configurar Nginx/Apache manualmente.
