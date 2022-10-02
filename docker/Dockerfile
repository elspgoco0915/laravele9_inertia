FROM php:8.0-apache
COPY ./php/php.ini /usr/local/etc/php/
COPY ./apache/*.conf /etc/apache2/sites-enabled/

#RUN apt-get update \
#  && apt-get install -y zlib1g-dev libpq-dev mariadb-client unzip vim\
#  && docker-php-ext-install zip pdo_mysql mysqli \
#  && docker-php-ext-enable mysqli

ENV TZ Asia/Tokyo
RUN apt-get update \
 && apt-get install -y zlib1g-dev libpq-dev mariadb-client zip unzip vim\
 &&
 # PHP BCMath
 && docker-php-ext-install bcmath \
 # PHP GD
 && apt-get install -y zlib1g-dev libpng-dev libjpeg62-turbo-dev \
 && docker-php-ext-configure gd --with-jpeg \
 && docker-php-ext-install -j$(nproc) gd \
 # PHP ZIP
 && apt-get install -y libzip-dev \
 && docker-php-ext-install zip \
 #
 && docker-php-ext-install pdo_mysql mysqli \
 && docker-php-ext-enable mysqli \
 # mod_rewrite有効化
 && a2enmod rewrite

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /composer
ENV PATH $PATH:/composer/vendor/bin

WORKDIR /var/www/html