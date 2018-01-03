FROM php:7.0-fpm

RUN docker-php-ext-install mysqli


EXPOSE 9000
CMD ["php-fpm"]
