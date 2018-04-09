#!/bin/bash
set -ev

composer install --prefer-dist
vendor/bin/codecept run tests/acceptance/pl/initPLCest.php --steps