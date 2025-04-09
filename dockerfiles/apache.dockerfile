# Use the official PHP with Apache image as base
FROM php:8.3-apache

ARG UID
ARG GID

ENV UID=${UID}
ENV GID=${GID}

# Create a user with the specified UID and GID
RUN usermod -u $UID www-data && groupmod -g $GID www-data

# Install required PHP extensions and other dependencies
RUN apt-get update && apt-get install -y \
    libapache2-mod-fcgid \
    && rm -rf /var/lib/apt/lists/*

# Enable Apache mod_rewrite
RUN a2enmod proxy_fcgi rewrite

# Set environment variable for custom document root
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

# Replace default Apache user and group (www-data) with 'laravel'
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Set working directory
WORKDIR /var/www/html

# Set permissions
RUN chown -R www-data:www-data /var/www/html
