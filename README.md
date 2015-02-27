# Laravel-Token-Auth
A token authentication package for Laravel 5.

### Installation

First of all install the package with composer:

    composer require susomena/token-auth

Then add the service provider to your config/app.php providers array:

    'Susomena\TokenAuth\TokenAuthServiceProvider',

Now you have to import config files and migrations from the package to your project with the following artisan command:

    artisan vendor:publish

And then migrate to add the credentials table to your database:

    artisan migrate


### Using TokenAuth

This package contains all the stuff needed to authenticate users with tokens. The package defines a route in `/credentials/login`, which expects two parameters by post, email and password. If this pair of parameters belong to an existent user the route returns a JSON object with a token with 24 hours of life (this value can be changed in the config/credentials.php file). It's important to remove CSRF middleware from app/Http/Kernel.php for making this route work. If you ant to use CSRF rotection in your routes place the CSRF middleware in the routeMidleware array instead of the middleware array.

This package also includes a TokenMiddleware that you can use with your routes. To do this add this middleware to the routeMiddleware array in app/Http/Kernel.php:
```php
    'token' => 'Susomena\TokenAuth\Middleware\TokenMiddleware'
```
And then, use this middleware in any route you want:
```php
    Route::get('path/of/the/route', ['middleware' => 'token', function(){
        // Closure logic
    }]);
```
