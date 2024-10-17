#!/bin/bash

git pull origin main
sudo find . -type f -exec chmod 644 {} \;
sudo find . -type d -exec chmod 755 {} \;
sudo chown -R $USER:www-data .
sudo chgrp -R www-data storage bootstrap/cache
sudo chmod -R ug+rwx bootstrap/cache
sudo chmod -R 775 database
sudo chown -R $(whoami) database
composer update
composer dump-autoload
php artisan migrate
php artisan optimize:clear
php artisan generate:sitemap
php artisan schedule:run
php artisan cache:clear
php artisan config:cache
