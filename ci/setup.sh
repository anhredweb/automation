#!/bin/bash
set -ev
# forcing localhost to be the 1st alias of 127.0.0.1 in /etc/hosts (https://github.com/seleniumhq/selenium/issues/2074)
sudo sed -i '1s/^/127.0.0.1 localhost\n/' /etc/hosts

sudo apt-get update -qq
#sudo apt-get install --yes --force-yes apache2 libapache2-mod-fastcgi oracle-java8-installer oracle-java8-set-default
npm install -g phantomjs-prebuilt
phantomjs -v

composer install

sh -e /etc/init.d/xvfb start
sleep 3 # give xvfb some time to start
