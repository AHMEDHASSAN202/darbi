#!/bin/sh

cd /var/www

#php artisan migrate
#php artisan module:seed
#php artisan cache:clear
#php artisan route:cache
php artisan darbi:reset

/usr/bin/supervisord -c /etc/supervisord.conf
