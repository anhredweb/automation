#!/bin/bash
set -ev

npm install -g gulp-cli

# forcing localhost to be the 1st alias of 127.0.0.1 in /etc/hosts (https://github.com/seleniumhq/selenium/issues/2074)
sudo sed -i '1s/^/127.0.0.1 localhost\n/' /etc/hosts # forcing localhost to be the 1st alias of 127.0.0.1 in /etc/hosts (https://github.com/seleniumhq/selenium/issues/2074)
sudo apt-get update -qq
sudo apt-get install -y --force-yes apache2 libapache2-mod-fastcgi > /dev/null
sudo mkdir $(pwd)/.run
chmod a+x tests/travis-php-fpm.sh
sudo ./tests/travis-php-fpm.sh $USER $(phpenv version-name)
sudo a2enmod rewrite actions fastcgi alias
echo "cgi.fix_pathinfo = 1" >> ~/.phpenv/versions/$(phpenv version-name)/etc/php.ini
~/.phpenv/versions/$(phpenv version-name)/sbin/php-fpm
sudo cp -f tests/travis-ci-apache.conf /etc/apache2/sites-available/default
sudo sed -e "s?%TRAVIS_BUILD_DIR%?$(pwd)?g" --in-place /etc/apache2/sites-available/default
sudo sed -e "s?%PHPVERSION%?${TRAVIS_PHP_VERSION:0:1}?g" --in-place /etc/apache2/sites-available/default
sudo service apache2 restart
"export DISPLAY=:99.0"
"sh -e /etc/init.d/xvfb start"
sleep 3 # give xvfb some time to start
sudo apt-get install fluxbox -y --force-yes
fluxbox &
sleep 3 # give fluxbox some time to start