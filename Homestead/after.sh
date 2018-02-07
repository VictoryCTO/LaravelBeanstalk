#!/bin/sh

# If you would like to do some extra provisioning you may
# add any commands you wish to this file and they will
# be run after the Homestead machine is provisioned.

# Composer Update
cd code
composer install 2>&1
sudo composer self-update 2>&1
php artisan migrate
php artisan db:seed
npm set progress=false && npm run dev 2>&1
