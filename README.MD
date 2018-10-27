# VenueManager
Test Application built with Laravel to Manage Venues

This application allows to build a set of Users and Venues and create "relations" between them.
The applications uses :
- `Laravel 5.7` Web Application Framework, for the backend.
- `VueJs` as Javascript Framework
- `MySQL` as Database (of course it depends from the configuration)

The application view is responsive, and uses the Ui framework `Boostrap`.

## Installation 

##### Requirements

- `PHP 7.2`
- `Composer`
- `NPM`
-  A `SQL` database (`MySQL`, `SQL Server` ..)

##### Installation steps

- Download the code.
- Run `Composer install`
- Run `Npm install`
- Configure `.env` file with your database server properties
- Run the command `php artisan app:install` to install configure the application (by running database migrations and seeding)
- Run the command `php artisan app:serve` to use the application without have to configure a web server (the application with start at <http://localhost:8000>)

##### DevTools
In `Devtools` folder there's an export of a collection of api requests created in `Postman`.
You can start the development by importing it in your Postman application <https://www.getpostman.com/>
