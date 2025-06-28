FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    unzip \
    curl \
    git \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    && docker-php-ext-install pdo_mysql mysqli zip

RUN docker-php-ext-install opcache

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -sS https://get.symfony.com/cli/installer | bash && \
    if [ -d "/root/.symfony5" ]; then mv /root/.symfony5/bin/symfony /usr/local/bin/symfony; fi

RUN composer require symfony/maker-bundle --dev

RUN composer require symfony/serializer-pack --dev
RUN composer require symfony/serializer --dev

EXPOSE 9000