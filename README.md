Symfony invoice generator
======
* A Symfony project created on December 30, 2024.
* Symfony Framework v6.4 application demoing an invoice generator

## System requirments / dependencies:
* Apache running on a linux server [512MB+ Ram]
* PHP 8.2+
* Composer
* MySQL

## Up and running of project
* Open .env file
* Remove comment(#) present against 'DATABASE_URL'
* Update values for "DATABASE_URL" (db_user,db_password,host,port,db_name)
* Open terminal in project folder
* Run the command "composer install"
* Run "php bin/console doctrine:database:create". This creates the database in mysql
* Run "php bin/console doctrine:schema:update --dump-sql". This shows you the various sql commands used to create the tables and columns
* Run "php bin/console doctrine:schema:update --force". This creates tables and respective tables for newly created database
* Run "php -S localhost:8000 -t public/". This command uses the built-in PHP web server to run the application
* The application should be up and running after performing steps mentioned above

## Project description
**Invoice generation flow**
* Visit "localhost:8000"
* If there are no customers present in the database, the page will redirect to "Create new customer" page
* Once customer is added, click "Add invoice" button present in top navigation bar
* Enter 10 digit contact number to login (no password or session used, user has to login using contact number everytime a new invoice is generated)
* Click on "Add a product" to add any product as an invoice item
* Item level price, discount and final item price will be calculated and displayed in read only fields
* Total amount and final amount will be shown below "Add a product"
* User can add a discount on the total amount, which will then update the read only final amount field 
* User can add a tax on the total amount, which will then update the read only final amount field
* Click on 'Save' will redirect you to an invoice page having newly added invoice details

**Invoice list**
* Users can view all the generated invoices by clicking on the 'Invoice' link provided in the navigation bar on top of the screen

**CRUD functionality for product,customer and category**
* Basic CRUD functionality can be accessed by clicking on respective links provided in the navigation bar on top of the screen
* Adding product without having a single category in database will redirect you to "Create new category" page

## Running tests
Run "./bin/phpunit" in terminal within project folder 