#!/bin/bash
set -ev
# forcing localhost to be the 1st alias of 127.0.0.1 in /etc/hosts (https://github.com/seleniumhq/selenium/issues/2074)
sudo sed -i '1s/^/127.0.0.1 localhost\n/' /etc/hosts

sudo apt-get update -qq
sudo apt-get install --yes --force-yes apache2 libapache2-mod-fastcgi oracle-java8-installer oracle-java8-set-default
sudo mkdir $(pwd)/.run

phpversionname="$(phpenv version-name)"
file="/home/$USER/.phpenv/versions/$phpversionname/etc/php-fpm.conf"
cp /home/$USER/.phpenv/versions/$phpversionname/etc/php-fpm.conf.default /home/$USER/.phpenv/versions/$phpversionname/etc/php-fpm.conf
if [ -f /home/$USER/.phpenv/versions/$phpversionname/etc/php-fpm.d/www.conf.default ]; then
	cp /home/$USER/.phpenv/versions/$phpversionname/etc/php-fpm.d/www.conf.default /home/$USER/.phpenv/versions/$phpversionname/etc/php-fpm.d/www.conf
	file=/home/$USER/.phpenv/versions/$phpversionname/etc/php-fpm.d/www.conf
fi;
sed -e "s,listen = 127.0.0.1:9000,listen = /tmp/php${phpversionname:0:1}-fpm.sock,g" --in-place $file
sed -e "s,;listen.owner = nobody,listen.owner = $USER,g" --in-place $file
sed -e "s,;listen.group = nobody,listen.group = $USER,g" --in-place $file
sed -e "s,;listen.mode = 0660,listen.mode = 0666,g" --in-place $file
sed -e "s,user = nobody,;user = $USER,g" --in-place $file
sed -e "s,group = nobody,;group = $USER,g" --in-place $file
sudo a2enmod rewrite actions fastcgi alias
echo "cgi.fix_pathinfo = 1" >> ~/.phpenv/versions/$phpversionname/etc/php.ini
~/.phpenv/versions/$(phpenv version-name)/sbin/php-fpm
sudo cp -f ./tests/travis-ci-apache.conf /etc/apache2/sites-available/default.conf
sudo sed -e "s?%TRAVIS_BUILD_DIR%?$(pwd)?g" --in-place /etc/apache2/sites-available/default.conf
sudo sed -e "s?%PHPVERSION%?${TRAVIS_PHP_VERSION:0:1}?g" --in-place /etc/apache2/sites-available/default.conf
sudo a2ensite default.conf
sudo service apache2 restart

composer require se/selenium-server-standalone
composer install

#sudo apt-get install fluxbox -y --force-yes
sh -e /etc/init.d/xvfb start
sleep 3
#fluxbox >/dev/null 2>&1 &