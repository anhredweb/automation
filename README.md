# FE Credit Automation Testing PEGA
Before running, you need to:
- Download Selenium Stand Alone on https://www.seleniumhq.org/download/
- Run selenium and chrome driver in cmd
```sh
java -jar -Dwebdriver.chrome.driver=".\chromedriver.exe" ".\selenium-server-standalone.jar"
```
- Install PHP v7.1.9
- Download PHP extensions for PHP 7.1: https://pecl.php.net/package/oci8
- Extract and copy to .\php\php7.1.9\ext
- Download Oracle Instant Client for Windows 64bit: http://www.oracle.com/technetwork/articles/winx64soft-089540.html
- Extract and copy into .\instantclient_11_2
- Go to System Properties\Enviroment Variables
- Add Path variable in System variables: .\instantclient_11_2
- Install composer then run:
```sh
composer install
```
- Init testing enviroment:
```sh
php .\vendor\bin\codecept bootstrap
```
- Run tests: 
```sh
.\vendor\bin\codecept run tests\acceptance\product_folder\file_name.php
```