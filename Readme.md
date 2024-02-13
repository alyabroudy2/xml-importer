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

start database container 
 ```
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
 ```
php bin/console app:xml-import
 ```

**C) Run tests:**
 ```
php bin/phpunit
 ```


**D) stop:**
 ```
docker compose down
 ```
### Note:
storage and log locations are limited to project working directory scope.
if location outside the project directory scope is required the request locations can be configured
as follow:
+ log location in `config/packages/monolog.yaml` as:
 ```
monolog:
    handlers:
        importer:
            path: "your/error/log/location"
 ```
+ storage location in `config/packages/flysystem.yaml` as:
 ```
flysystem:
    storages:
        xml.storage:
            adapter: 'local'
            options:
                directory: "your/xml-storage/location"
 ```
