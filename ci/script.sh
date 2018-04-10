#!/bin/bash
set -ev

php vendor/bin/robo run:travis
vendor/bin/codecept run tests/acceptance/pl/initPLCest.php --steps