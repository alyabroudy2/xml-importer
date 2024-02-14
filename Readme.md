**Symfony 6.4 App imports Data from XML files and push it to database 


**Requirement:** 

* php 8.1 
    + pdo_mysql extension for database 
    + mbstring extension for phpunit

* composer 

* docker for database container 
--------------------------------------------------
**A) Setup**

modify database configs in `.env` file as:
 ```yaml
DB_USER=root
DB_PASS=password
DB_HOST=127.0.0.1
DB_NAME=main
DB_ROOT_PASSWORD=root
DATABASE_URL=mysql://$DB_USER:$DB_PASS@$DB_HOST:3306/$DB_NAME?serverVersion=10.9.3-MariaDB&charset=utf8mb4
 ```

and the xml storage location and the error log location in `.env` file as:
 ```yaml
XML_STORAGE_PATH='var/storage/xml'
XML_ERROR_LOG_PATH='var/storage/log/xml_log.log'
 ```

**install:**
 ```shell
composer install
 ```

start database container 
 ```shell
docker compose up -d
 ```

**Phpmyadmin** 
goto: http://127.0.0.1:81
 ``` 
server: db
user: root
pass: password
 ```

create the database
 ```
php bin/console doctrine:database:create
 ```

migrate database changes
 ```
php bin/console doctrine:migration:migrate -q
 ```
-------------------------------
**B) Run the import command:**
 ```shell
php bin/console app:xml-import
 ```

**C) Run tests:**
 ```shell
php bin/phpunit
 ```


**D) stop:**
 ```shell
docker compose down
 ```