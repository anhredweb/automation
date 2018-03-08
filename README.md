# FE Credit Automation Testing PEGA
Before you can run you need to:
- Install PHP v7.1.9
- Download PHP extensions for PHP 7.1: https://pecl.php.net/package/oci8
- Extract and copy to .\php\php7.1.9\ext
- Download Oracle Instant Client for Windows 64bit: http://www.oracle.com/technetwork/articles/winx64soft-089540.html
- Extract and copy into .\instantclient_11_2
- Go to System Properties\Enviroment Variables
- Add Path variable in System variables: .\instantclient_11_2
- Install composer then run: composer install
- Init testing enviroment: php .\vendor\bin\codecept bootstrap
- Run tests: .\vendor\bin\codecept run tests\acceptance\product_folder\file_name.php