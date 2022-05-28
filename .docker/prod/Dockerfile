FROM php:8.1-fpm
RUN apt-get update
RUN docker-php-ext-install pdo pdo_mysql mysqli

RUN apt-get install -y autoconf pkg-config libssl-dev nginx supervisor
RUN pecl install mongodb
RUN echo "extension=mongodb.so" >> /usr/local/etc/php/conf.d/mongodb.ini
# RUN apt-get install zip unzip php8.1-zip
RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libzip-dev \
    unzip
RUN docker-php-ext-install zip

# Install Packages
# RUN apk --no-cache add php8 php8-fpm php8-opcache php8-mysqli php8-json php8-openssl php8-curl \
#     php8-simplexml php8-iconv php8-tokenizer php8-pdo php8-fileinfo php8-xmlwriter php8-zip php8-gd \
#     php8-zlib php8-xml php8-phar php8-intl php8-dom php8-xmlreader php8-ctype php8-session php8-mbstring \
#     php8-pdo_mysql php8-redis libzip-dev libpng-dev musl-locales musl-locales-lang nginx supervisor curl nano bash \
#     wkhtmltopdf libstdc++ libx11 libxrender libxext ca-certificates fontconfig freetype ttf-dejavu ttf-droid ttf-freefont ttf-liberation php8-gmp

# RUN wget https://github.com/FriendsOfPHP/pickle/releases/download/v0.6.0/pickle.phar && mv pickle.phar /usr/local/bin/pickle
# RUN chmod +x /usr/local/bin/pickle

# # RUN apk --no-cache add php7-pear php7-dev gcc musl-dev make
# # RUN pecl install xdebug

# # Configure Nginx
RUN apk --no-cache add nginx supervisor curl nano bash
COPY .docker/nginx.conf /etc/nginx/nginx.conf
# RUN ln -s /usr/bin/php8 /usr/bin/php
# RUN pickle install apcu
# RUN pickle install mongodb

# # RUN ls /usr/bin/php8
# RUN echo "extension=mongodb.so" >> /etc/php8/conf.d/mongodb.ini

# # Configure PHP-FPM
# COPY .docker/fpm-pool.conf /etc/php7/php-fpm.d/www.conf
# COPY .docker/php.ini /etc/php7/conf.d/custom.ini

# # Configure Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# # Configure Supervisord
COPY .docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# # Configure Wkhtmltopdf
# RUN mv /usr/bin/wkhtmltopdf /usr/local/bin/wkhtmltopdf

# Create Working Dir
RUN mkdir -p /var/www/html

# Add Application
WORKDIR /var/www/html
COPY . /var/www/html/
COPY .env.example /var/www/html/.env

# Ceate Sub Directories
RUN mkdir -p /var/www/html/storage/framework/cache/data && \
    mkdir -p /var/www/html/storage/framework/sessions && \
    mkdir -p /var/www/html/storage/framework/testing && \
    mkdir -p /var/www/html/storage/framework/views

# Configure User
# RUN adduser --system --group system
RUN adduser --system --group system && \
    chown -R system.system /var/www/html && \
    chown -R system.system /run && \
    chown -R system.system /var/lib/nginx && \
    chown -R system.system /var/log/nginx

# Switch To User
USER system

# Composer Install
RUN composer self-update --stable
RUN composer install

# Expose Port
EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]