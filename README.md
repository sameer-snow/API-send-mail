# ![API Send mail Laravel]

> ### This Laravel codebase containing Send mail API example.

----------

# Getting started

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/8.x/installation)

Clone the repository

    git clone git@github.com:sameer-snow/API-send-mail.git
    OR
    (Manual) Download Source zip and extract into htdocs/API-send-mail OR www/API-send-mail

Switch to the repo folder

    cd API-send-mail

Install all the dependencies using composer

    composer install
    OR
    composer install --ignore-platform-reqs (for windows use this - dependencies not work without PHP ext-pcntl)

If .env file not exist then Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Configure the mailer, I set mailtrap SMTP settings

	MAIL_MAILER=smtp
	MAIL_HOST=smtp.mailtrap.io
	MAIL_PORT=2525
	MAIL_USERNAME=c76163ec1ccfef (set mailtrap username)
	MAIL_PASSWORD=2f29c5280973fd (set mailtrap password)
	MAIL_ENCRYPTION=tls

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

**TL;DR command list**

    git clone git@github.com:sameer-snow/API-send-mail.git (Skip this step in the case of manually extracted the source code)
    cd API-send-mail
    composer install OR composer install --ignore-platform-reqs (for windows use this - dependencies not work without PHP ext-pcntl)
    cp .env.example .env
    php artisan key:generate 
    
**Make sure you set the correct database connection information before running the migrations** [Environment variables](#environment-variables)

    php artisan migrate
    php artisan serve

The api can be accessed at [http://localhost:8000/api/v1](http://localhost:8000/api/v1).

## API Specification

This application adheres to the api specifications set by the Samir (https://github.com/sameer-snow).
> [Full API Spec](https://github.com/sameer-snow/API-send-mail/blob/master/postman_api.php)

----------

# Code overview

## Dependencies (Note: Not working for the windows)

- [predis](https://github.com/predis/predis)
- [laravel-horizon](https://github.com/laravel/horizon)

## Environment variables

- `.env` - Environment variables can be set in this file
- Update QUEUE_CONNECTION=redis
- Add REDIS_CLIENT=predis
- While successfully work redis queue you have to run `php artisan queue:work` command in order to execute the queue

## Folders

- `app/Models` - Contains all the Eloquent models
- `app/Http/Controllers/Api` - Contains all the api controllers
- `app/Http/Middleware` - Contains the API auth middleware
- `config` - Contains all the application configuration files
- `database/factories` - Contains the model factory for all the models
- `database/migrations` - Contains all the database migrations
- `database/seeds` - Contains the database seeder
- `routes` - Contains all the api routes defined in api.php file
- `public/attachments` - Contains all the mail attachments

***Note*** : You can quickly set the database information and other variables in this file and have the application fully working.

----------

# Testing API

Run the laravel development server

    php artisan serve

The api can now be accessed at

    http://localhost:8000/api

Request headers

| **Required** 	| **Key**              	| **Value**            	|
|----------	|------------------	|------------------	|
| Yes      	| Content-Type     	| application/json 	|
| Yes      	| X-Requested-With 	| XMLHttpRequest   	|

Refer the [api specification](https://github.com/sameer-snow/API-send-mail/blob/master/postman_api.php) for more info.

----------

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
