#!/bin/bash
set -ev

java -jar -Dwebdriver.chrome.driver="chrome_driver/chromedriver" "selenium-server-standalone.jar"
vendor/bin/codecept run tests/acceptance/pl/initPLCest.php --steps