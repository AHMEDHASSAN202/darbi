#!/bin/sh

cd /var/www

#php artisan migrate
#php artisan module:seed
php artisan cache:clear
php artisan route:cache

/usr/bin/supervisord -c /etc/supervisord.conf
