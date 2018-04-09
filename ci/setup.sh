#!/bin/bash
set -ev

if [ "${ACCEPTANCE}" = "false" ]; then
	git submodule update --init --recursive

	# Following line uses a bot account to authenticate in github and make composer stable and faster, see https://redweb.atlassian.net/wiki/pages/viewpage.action?pageId=46694753
	composer config -g github-oauth.github.com "${GITHUB_TOKEN}"
	composer global require hirak/prestissimo
	composer install --prefer-dist
	composer install --working-dir ./libraries/redshop --ansi
else
	npm install -g gulp-cli

	# forcing localhost to be the 1st alias of 127.0.0.1 in /etc/hosts (https://github.com/seleniumhq/selenium/issues/2074)
	sudo sed -i '1s/^/127.0.0.1 localhost\n/' /etc/hosts

	sudo apt-get update -qq
  	sudo apt-get install --yes --force-yes apache2 libapache2-mod-fastcgi
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

	sh -e /etc/init.d/xvfb start
	sleep 3
	sudo apt-get install fluxbox -y --force-yes
	fluxbox &
	sleep 3

	composer install

	npm install

	sudo apt-get install oracle-java8-installer
	sudo apt-get install oracle-java8-set-default

	# Install Chrome.
	sudo curl -sS -o - https://dl-ssl.google.com/linux/linux_signing_key.pub | apt-key add
	sudo echo "deb http://dl.google.com/linux/chrome/deb/ stable main" >> /etc/apt/sources.list.d/google-chrome.list
	sudo apt-get -y update
	sudo apt-get -y install google-chrome-stable

	# Install ChromeDriver.
	wget -N http://chromedriver.storage.googleapis.com/$CHROME_DRIVER_VERSION/chromedriver_linux64.zip -P ~/
	unzip ~/chromedriver_linux64.zip -d ~/
	rm ~/chromedriver_linux64.zip
	sudo mv -f ~/chromedriver /usr/local/bin/chromedriver
	sudo chown root:root /usr/local/bin/chromedriver
	sudo chmod 0755 /usr/local/bin/chromedriver

	# Install Selenium.
	wget -N http://selenium-release.storage.googleapis.com/$SELENIUM_SUBDIR/selenium-server-standalone-$SELENIUM_STANDALONE_VERSION.jar -P ~/
	sudo mv -f ~/selenium-server-standalone-$SELENIUM_STANDALONE_VERSION.jar /usr/local/bin/selenium-server-standalone.jar
	sudo chown root:root /usr/local/bin/selenium-server-standalone.jar
	sudo chmod 0755 /usr/local/bin/selenium-server-standalone.jar
fi