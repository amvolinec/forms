Add to /config/app.php:

`Avart\Forms\FormsServiceProvider::class,`

And to the composer.json:

    "autoload": {
        "psr-4": {
            ...
            "Avart\\Forms\\": "packages/avart/forms/src",
            "Avart\\Forms\\Seeds\\": "packages/avart/forms/src/seeds"
        },

Then run

`composer dumpautoload`

`php artisan migrate`

`php artisan db:seed --class="Avart\Forms\Seeds\TypeSeeder"`

`php artisan vendor:publish --tag=public --force`
