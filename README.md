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

Note that the migrations are made by alphabetical order. If you have created your own users table with your own migration, laravel will try to create the credentials table before your users table, and the foreign key existent in this table won't point to any users field, because users table don't exists. In this case, you'll have to change the name of the credentials migration file to let it appear after your migration. For example, the credentials migration file is named:

    2015_02_27_100000_create_credentials_table.php

If your users table migration file is named:

    2015_03_02_100000_create_users_table.php

Then you can rename he credentials table migration like this:

    2015_03_02_200000_create_credentials_table.php

Also, you can use a migration to alter the original laravel users table to make it like the one one you want.

If you get any error like this one:

    PHP Fatal error:  Class 'Susomena\TokenAuth\TokenAuthServiceProvider' not found in /ProjectPath/vendor/laravel/framework/src/Illuminate/Foundation/ProviderRepository.php on line 150

After a composer or artisan command, just comment the TokenAuthServiceProvider in you config/app.php providers array, launch the command again and then uncomment the line. This is just a dirty workaround while I try to fix this issue.


### Using TokenAuth

This package contains all the stuff needed to authenticate users with tokens. The package defines a route in `/credentials/login`, which expects two parameters by HTTP POST, a username (by default an email field of the database, this can be changed in the config/credentials.php file) and a password. If this pair of parameters belong to an existent user the route returns a JSON object with the credentials object (which contains a token with 24 hours of life, this value can be changed in the config/credentials.php file) and the user which owns the token. The following is an example of that JSON:

```json
    {
        "id": 27,
        "token": "54fd719a611105.13505663",
        "expires": 1425982234,
        "user_id": 1,
        "created_at": "2015-03-09 10:10:34",
        "updated_at": "2015-03-09 10:10:34",
        "user": {
            "id": 1,
            "name": "Name",
            "email": "email@email.com",
            "created_at": "2015-03-06 12:22:01",
            "updated_at": "2015-03-06 12:22:01"
        }
    }
```

It's important to remove CSRF middleware from app/Http/Kernel.php for making this route work. If you want to use CSRF rotection in your routes place the CSRF middleware in the routeMidleware array instead of the middleware array.

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
Now, if you want to authenticate your user with a token you'll have to user the `/credentials/login` route to authenticate the user's username and password and get a valid token for this user, then you'll have to send this token in every HTTP request by putting it in a HTTP header called `X-Credentials-Token`.
