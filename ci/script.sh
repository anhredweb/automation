#!/bin/bash
set -ev

phantomjs --webdriver=4444
vendor/bin/codecept run tests/acceptance/pl/initPLCest.php --steps