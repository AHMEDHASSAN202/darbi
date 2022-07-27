
FROM php:8.1.4-fpm


# Add docker php ext repo
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

# Install php extensions
RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions mbstring pdo_mysql zip exif pcntl gd memcached

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    unzip \
    git \
    curl \
    lua-zlib-dev \
    libmemcached-dev \
    libssl-dev pkg-config \
    nginx


# Install Mongodb

RUN pecl install mongodb
RUN pecl install redis

RUN echo "extension=mongodb.so" >> /usr/local/etc/php/conf.d/php.ini


# Install redis extension
RUN pecl install -o -f redis \
&&  rm -rf /tmp/pear \
&&  docker-php-ext-enable redis

# Install supervisor
RUN apt-get install -y supervisor

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Set working directory
WORKDIR /var/www

# Copy project files to container
COPY . /var/www

# Copy nginx/php/supervisor configs
RUN cp docker/supervisor.conf /etc/supervisord.conf
RUN cp docker/php.ini /usr/local/etc/php/conf.d/app.ini
RUN cp docker/nginx.conf /etc/nginx/sites-enabled/default

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Change ownership to www for project
RUN chown -R www:www /var/www

# # add root to www group
RUN chmod 777 /var/www/storage
RUN chmod 777 /var/www/storage/logs

# change ownership for directories to www
RUN chown -R www /var/www/html && \
    chown -R www /run && \
    chown -R www /var/lib/nginx && \
    chown -R www /var/log/nginx && \
    chown -R www /var/log/

# Switch user to www
USER www

# PHP Error Log Files
RUN mkdir /var/log/php
RUN touch /var/log/php/errors.log && chmod 777 /var/log/php/errors.log

# Deployment steps
RUN composer require jenssegers/mongodb --ignore-platform-reqs --with-all-dependencies
RUN composer install --ignore-platform-reqs
RUN chmod +x /var/www/docker/run.sh


# Setup cron job
#RUN (crontab -l ; echo "* * * * * cd /var/www && php artisan schedule:run >> /dev/null 2>&1") | crontab


# open port 80
EXPOSE 80

ENTRYPOINT ["/var/www/docker/run.sh"]
