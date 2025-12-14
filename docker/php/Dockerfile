FROM php:8.3.3-fpm

# System deps needed for common Laravel requirements + zip
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    libzip-dev \
  && rm -rf /var/lib/apt/lists/*

# PHP extensions (minimal for Laravel + MySQL + zip)
RUN docker-php-ext-install pdo_mysql zip opcache

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www/html
