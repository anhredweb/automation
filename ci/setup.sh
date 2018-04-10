#!/bin/bash
set -ev
# forcing localhost to be the 1st alias of 127.0.0.1 in /etc/hosts (https://github.com/seleniumhq/selenium/issues/2074)
sudo sed -i '1s/^/127.0.0.1 localhost\n/' /etc/hosts

sudo apt-get update -qq
#sudo apt-get install --yes --force-yes apache2 libapache2-mod-fastcgi oracle-java8-installer oracle-java8-set-default
sudo wget https://bitbucket.org/ariya/phantomjs/downloads/phantomjs-1.9.7-linux-x86_64.tar.bz2
sudo tar xjf phantomjs-1.9.7-linux-x86_64.tar.bz2
sudo ln -s /phantomjs-1.9.7-linux-x86_64/bin/phantomjs /phantomjs
sudo ln -s /phantomjs-1.9.7-linux-x86_64/bin/phantomjs /phantomjs
sudo ln -s /phantomjs-1.9.7-linux-x86_64/bin/phantomjs /phantomjs

composer install

sh -e /etc/init.d/xvfb start
sleep 3 # give xvfb some time to start
