First of all create database for your project configuration. 
For example: `project_forms`.

Add settings to the .env file:

    DB_CONNECTION_SECOND=mysql
    DB_HOST_SECOND=127.0.0.1
    DB_PORT_SECOND=3306
    DB_DATABASE_SECOND=project_forms
    DB_USERNAME_SECOND=username
    DB_PASSWORD_SECOND=password

And following to the config/database.php:

    'mysql2' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST_SECOND', '127.0.0.1'),
            'port' => env('DB_PORT_SECOND', '3306'),
            'database' => env('DB_DATABASE_SECOND', 'forge'),
            'username' => env('DB_USERNAME_SECOND', 'forge'),
            'password' => env('DB_PASSWORD_SECOND', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ], 
 

Create folder `packages/avart/` in the app root folder.

Change directory to `packages/avart/`.

Run `git clone https://github.com/amvolinec/laravel-forms.git forms` to clone `forms` into right folder.

Add 

`Avart\Forms\FormsServiceProvider::class,`

to the /config/app.php file and

    "autoload": {
        "psr-4": {
        
            ...
            
            "Avart\\Forms\\": "packages/avart/forms/src",
            "Avart\\Forms\\Models\\": "packages/avart/forms/src/models",
            "Avart\\Forms\\Controllers\\": "packages/avart/forms/src/controllers"
            
            ...
            
        },

to the composer.json file.

Run

`composer dumpautoload`

`php artisan vendor:publish --provider="Avart\Forms\FormsServiceProvider" --force`

Add 

`$this->call(TypeSeeder::class);` 

to the 

`database/seeds/DatabaseSeeder.php`

Run

`composer dumpautoload`

`php artisan migrate:fresh --seed`


Create a form:

`form:create Model`
