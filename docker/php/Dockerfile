# Dockerfile
FROM php:7.4-apache

# Ativa o mod_rewrite do Apache
RUN a2enmod rewrite

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip

RUN docker-php-ext-install mysqli pdo_mysql mbstring exif gd zip

