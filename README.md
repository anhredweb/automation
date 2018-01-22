# FE Credit Automation Testing PEGA
Before you can run you need to:
- Install PHP v7.1.9
- Download PHP extensions: https://pecl.php.net/package/oci8
- Then copy to .\php\php7.1.9\ext
- Download Oracle Instant Client: http://www.oracle.com/technetwork/articles/winx64soft-089540.html
- Then extract and copy into C:\instantclient_11_2
- Go to System Properties\Enviroment Variables
- Add Path variable in System variables: C:\instantclient_11_2
- Install composer then run: composer install
- Initialize testing enviroment: php vendor\bin\codecept bootstrap
- To run tests: vendor\bin\codecept run tests\acceptance\product_folder\file_name.php