# Dockerfile
FROM php:7.4-apache

# Ativa o mod_rewrite do Apache
RUN a2enmod rewrite

# Copiar seu php.ini
COPY php.ini /usr/local/etc/php/php.ini

# (Opcional) VirtualHost customizado
COPY ./apache/vhost.conf /etc/apache2/sites-available/000-default.conf

RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libjpeg-dev\
    libfreetype6-dev\
    libssl-dev\
    libicu-dev\
    default-mysql-client\   
    unzip
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

RUN docker-php-ext-install mysqli pdo pdo_mysql mbstring exif intl gd zip opcache bcmath soap

