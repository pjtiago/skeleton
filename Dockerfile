FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
  git zip unzip libpng-dev \
  libzip-dev default-mysql-client

RUN docker-php-ext-install pdo pdo_mysql zip gd

#RUN a2enmod rewrite

WORKDIR /var/www/app

COPY . /var/www/app

#RUN php bin/console doctrine:migrations:migrate

COPY 000-default.conf /etc/apache2/sites-available

#RUN chown -R www-data:www-data /var/www/app \
#    && chown -R 775 /var/www/app

RUN a2enmod rewrite && service apache2 restart

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --no-scripts --no-autoloader

EXPOSE 80

CMD ["apache2-foreground"]