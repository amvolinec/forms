Create folder `packages/avart/` in the app root folder.
    
    mkdir packages
    cd packages
    mkdir avart
    cd avart

Change directory to `packages/avart/`.

Run `git clone https://github.com/amvolinec/laravel-forms.git forms` to clone `forms` into right folder.

Add  to .env file:

    DB_FORMS_CONNECTION=forms
    DB_FORMS_HOST=db
    DB_FORMS_PORT=3306
    DB_FORMS_DATABASE=dbname
    DB_FORMS_USERNAME=dbusername
    DB_FORMS_PASSWORD=dbpassword


Add to config\database.php new connection

    'forms' => [
        'driver' => 'mysql',
        'url' => env('DATABASE_URL'),
        'host' => env('DB_FORMS_HOST', '127.0.0.1'),
        'port' => env('DB_FORMS_PORT', '3306'),
        'database' => env('DB_FORMS_DATABASE', 'forge'),
        'username' => env('DB_FORMS_USERNAME', 'forge'),
        'password' => env('DB_FORMS_PASSWORD', ''),
        'unix_socket' => env('DB_SOCKET', ''),
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => true,
        'engine' => null,
        'options' => extension_loaded('pdo_mysql') ? array_filter([
            PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
        ]) : [],
    ],

Add 

`Avart\Forms\FormsServiceProvider::class,`

to the /config/app.php file and

    "autoload": {
        "psr-4": {
        
            ...
            
            "Avart\\Forms\\": "packages/avart/forms/src",
            "Avart\\Forms\\Models\\": "packages/avart/forms/src/models",
            "Avart\\Forms\\Controllers\\": "packages/avart/forms/src/controllers",
            "Avart\\Forms\\Requests\\": "packages/avart/forms/src/requests",
            "Avart\\Forms\\Creators\\": "packages/avart/forms/src/creators"
            
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

 `php artisan migrate`
 
 `php artisan db:seed --class=TypeSeeder`

Install laravel/permission

https://spatie.be/docs/laravel-permission/v4/installation-laravel
https://spatie.be/docs/laravel-permission/v4/basic-usage/basic-usage

Install the font awesome:

`npm install --save @fortawesome/fontawesome-free` or `yarn add @fortawesome/fontawesome-free`

Add to the app.scss file following lines:

    @import '~@fortawesome/fontawesome-free/scss/fontawesome';
    @import '~@fortawesome/fontawesome-free/scss/regular';
    @import '~@fortawesome/fontawesome-free/scss/solid';
    @import '~@fortawesome/fontawesome-free/scss/brands';

`npm run dev` or `yarn run dev`

Please register find component in to the `resources/js/app.js` 

    Vue.component('find', require('./components/FindComponent.vue').default);

If you want publish only find component:

    php artisan vendor:publish --tag=find --force 

How to use:

    php artisan make:form Model
