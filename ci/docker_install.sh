#!/bin/bash

# We need to install dependencies only for Docker
[[ ! -e /.dockerenv ]] && exit 0

set -xe

sudo apt-get update -yqq
sudo apt-get install curl php7.0-cli git -yqq
curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/
php /composer
composer install

# Install phpunit, the tool that we will use for testing
curl --location --output /usr/local/bin/phpunit https://phar.phpunit.de/phpunit.phar
chmod +x /usr/local/bin/phpunit