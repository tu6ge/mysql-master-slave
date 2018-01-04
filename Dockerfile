FROM php:7.0-fpm
MAINTAINER tu6ge 772364230@qq.com

RUN docker-php-ext-install mysqli
ENV MASTER_DB_LINK mysql://root:password@master
ENV SLAVE_DB_LINKS mysql://root:password@slave

EXPOSE 9000
CMD ["php","mysql.php"]
