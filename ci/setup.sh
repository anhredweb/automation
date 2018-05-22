#!/bin/bash
set -ev

sudo apt-get update -qq

sh -e /etc/init.d/xvfb start
sleep 3
#sudo apt-get install fluxbox -y --force-yes
#fluxbox &
#sleep 3

composer install