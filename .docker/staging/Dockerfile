FROM alpine:3.14

# Install Packages
RUN apk --no-cache add php7 php7-fpm php7-opcache php7-mysqli php7-json php7-openssl php7-curl \
    php7-simplexml php7-iconv php7-tokenizer php7-pdo php7-fileinfo php7-xmlwriter php7-zip php7-gd \
    php7-zlib php7-xml php7-phar php7-intl php7-dom php7-xmlreader php7-ctype php7-session php7-mbstring \
    php7-pdo_mysql php7-redis libzip-dev libpng-dev musl-locales musl-locales-lang nginx supervisor curl nano bash \
    wkhtmltopdf libstdc++ libx11 libxrender libxext ca-certificates fontconfig freetype ttf-dejavu ttf-droid ttf-freefont ttf-liberation php7-gmp
# Configure Nginx
COPY .docker/nginx.conf /etc/nginx/nginx.conf

# Configure PHP-FPM
COPY .docker/fpm-pool.conf /etc/php7/php-fpm.d/www.conf
COPY .docker/php.ini /etc/php7/conf.d/custom.ini

# Configure Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Configure Supervisord
COPY .docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Configure Wkhtmltopdf
RUN mv /usr/bin/wkhtmltopdf /usr/local/bin/wkhtmltopdf

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
RUN addgroup -S system && adduser -S system -G system && \
    chown -R system.system /var/www/html && \
    chown -R system.system /run && \
    chown -R system.system /var/lib/nginx && \
    chown -R system.system /var/log/nginx

# Switch To User
USER system

# Composer Install
RUN composer install

# Expose Port
EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
