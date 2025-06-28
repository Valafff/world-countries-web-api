# Используем официальный образ PHP версии 8.2 с FPM (FastCGI Process Manager)
FROM php:8.2-fpm

# Обновляем список пакетов и устанавливаем необходимые пакеты для работы с PHP и его расширениями
RUN apt-get update && apt-get install -y \
wget \
unzip \
curl \
git \
libpng-dev \
libjpeg-dev \
libfreetype6-dev \
libzip-dev \
&& docker-php-ext-install pdo_mysql mysqli zip

# Устанавливаем расширение OPcache для PHP, которое улучшает производительность за счет кэширования байт-кода
RUN docker-php-ext-install opcache

# Устанавливаем Composer, менеджер зависимостей для PHP, в директорию /usr/local/bin, чтобы он был доступен в PATH
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# # Устанавливаем Symfony CLI, инструмент командной строки для работы с Symfony
# RUN curl -sS https://get.symfony.com/cli/installer | bash && \
#  if [ -d "/root/.symfony5" ]; then mv /root/.symfony5/bin/symfony /usr/local/bin/symfony; fi

# Устанавливаем Symfony CLI, инструмент командной строки для работы с Symfony 2й
RUN wget https://get.symfony.com/cli/installer -O - | bash && \
    mv /root/.symfony5/bin/symfony /usr/local/bin/symfony


# Устанавливаем Symfony Maker Bundle, который предоставляет команды для генерации кода в Symfony
RUN composer require symfony/maker-bundle --dev

# Устанавливаем пакет Symfony Serializer Pack, который включает в себя сериализатор и другие полезные компоненты
RUN composer require symfony/serializer-pack --dev

# Устанавливаем компонент Symfony Serializer, который предоставляет функциональность для сериализации и десериализации объектов
RUN composer require symfony/serializer --dev

# Фиксация совместимых версий
RUN composer require phpstan/phpdoc-parser:^1.8 symfony/property-info:^6.3

# Открываем порт 9000 для доступа к PHP-FPM извне контейнера
EXPOSE 9000
