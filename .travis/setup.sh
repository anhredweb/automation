#!/bin/bash
set -ev

apt-get update -yqq
apt-get install zip unzip
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
php -r "unlink('composer-setup.php');"
php composer.phar install