# Dockerfile
FROM php:8.1-fpm

# Instalar las dependencias necesarias
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libonig-dev \
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-install intl pdo_mysql mbstring zip opcache

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar el directorio de trabajo
WORKDIR /var/www

# Copiar el proyecto Symfony
COPY . .

# Instalar las dependencias del proyecto
RUN composer install
