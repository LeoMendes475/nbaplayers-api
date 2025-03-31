# Etapa 1 - Build do frontend
FROM node:20-alpine as frontend

WORKDIR /app

# Etapa 2 - Backend Laravel
FROM php:8.3-fpm-alpine

# Dependências
RUN apk add --no-cache \
    bash \
    git \
    unzip \
    curl \
    sqlite \
    sqlite-dev \
    libpng-dev \
    oniguruma-dev \
    libxml2-dev \
    zip \
    npm \
    freetype-dev \
    libjpeg-turbo-dev \
    icu-dev \
    zlib-dev \
    libzip-dev

# Extensões PHP
RUN docker-php-ext-install pdo pdo_sqlite mbstring exif pcntl bcmath gd intl zip

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# App
WORKDIR /var/www
COPY . .

# Permissões
RUN chown -R www-data:www-data /var/www

# Porta PHP
EXPOSE 9000

CMD ["php-fpm"]