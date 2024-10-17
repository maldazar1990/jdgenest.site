#!/bin/bash
cp -r laravel/* .
composer update
composer dump-autoload
php artisan migrate
php artisan optimize:clear
php artisan generate:sitemap
php artisan schedule:run
php artisan cache:clear
php artisan config:cache
