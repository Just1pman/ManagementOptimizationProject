FROM php:7.4-fpm

MAINTAINER just1pman "Just1pman@gmail.com"
RUN apt-get update && apt-get install -y \
        default-mysql-client \
        libpng-dev \
        libonig-dev \
        libzip-dev \
        wget \
        git \
        npm

RUN docker-php-ext-install pdo_mysql \
        zip \
        gd

#install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet
ENV COMPOSER_ALLOW_SUPERUSER 1

#install nodejs
RUN curl -sL https://deb.nodesource.com/setup_15.x | bash && npm cache clean -f && npm install -g n && n stable

#install symfony
RUN wget https://get.symfony.com/cli/installer -O - | bash
RUN mv /root/.symfony/bin/symfony /usr/local/bin/symfony

#install xdebug
RUN pecl install xdebug-2.9.8 \
    && docker-php-ext-enable xdebug \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_host = 172.17.0.1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.idekey = PHPSTORM" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_autostart = 1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_port = 9001" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \

WORKDIR /var/www/html

#------Write inside the container------

#create symfony skeleton
#RUN composer create-project symfony/website-skeleton symfony
#in the symphony folder run (
#    composer require encore
#    npm install
#    npm install @symfony/webpack-encore --save-dev
#    npm install sass-loader@^9.0.1 node-sass@4.14.1 --dev
#    npm install materialize-css@next