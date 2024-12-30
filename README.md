symfony-invoice-generator
======

A Symfony project created on December 30, 2024.
## symfony-invoice-generator
* Symfony Framework v6.4 application demoing an invoice generator

## System requirments / dependencies:
* Apache running on a linux server [512MB+ Ram]
* PHP 8.2+
* Composer
* MySQL

## Up and running of project
* Open .env file
* Remove comment(#) present against 'DATABASE_URL'
* Update values for "DATABASE_URL" (db_user,db_password,host,port,db_name,etc)
* Open terminal in project folder
* Run the command "composer install"
* Run "php bin/console doctrine:database:create". This creates the database in mysql
* Run "php bin/console doctrine:schema:update --dump-sql". This shows you the various sql commands used to create the tables and columns
* Run "php bin/console doctrine:schema:update --force". This creates tables and respective tables for newly created database
* Run "php -S localhost:8000 -t public/". This command uses the built-in PHP web server to run the application
* The application should be up and running after performing steps mentioned above