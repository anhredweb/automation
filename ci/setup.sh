#!/bin/bash
set -ev

sudo apt-get update -qq

composer require se/selenium-server-standalone
composer install

sh -e /etc/init.d/xvfb start
sleep 3