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
            "Avart\\Forms\\Seeds\\": "packages/avart/forms/src/seeds"
            
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

`form:create Model`t 
