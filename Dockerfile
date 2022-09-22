FROM php:7.4-apache

# Update - Upgrade and install zip
#RUN apt update
#RUN apt upgrade -y
#RUN apt install zip unzip -y

# Install Composer
#RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#install phpunit on composer
#RUN composer require --dev phpunit/phpunit ^9.5

ENV APACHE_DOCUMENT_ROOT /var/www/source

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
