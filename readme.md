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

`php artisan migrate:fresh --seed`

Install the font awesome:

`npm install --save @fortawesome/fontawesome-free`

Add to the app.scss file following lines:

    @import '~@fortawesome/fontawesome-free/scss/fontawesome';
    @import '~@fortawesome/fontawesome-free/scss/regular';
    @import '~@fortawesome/fontawesome-free/scss/solid';
    @import '~@fortawesome/fontawesome-free/scss/brands';

`npm run dev`

Please register find component in to the `resources/js/app.js` 

    Vue.component('find', require('./components/FindComponent.vue').default);



To create a form from model `Model`:

`form:create Model`
