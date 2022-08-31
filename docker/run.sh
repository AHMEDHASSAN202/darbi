#!/bin/sh

cd /var/www

php artisan migrate
php artisan cache:clear
php artisan route:cache
php artisan config:clear

/usr/bin/supervisord -c /etc/supervisord.conf
