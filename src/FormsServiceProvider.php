<?php

namespace Avart\Forms;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\ServiceProvider;

class FormsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     * @throws BindingResolutionException
     */
    public function register()
    {
        $this->app->make('Avart\Forms\Controllers\FieldsController');
        $this->loadViewsFrom(__DIR__.'/views', 'forms');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        include __DIR__.'/routes.php';
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeForm::class,
            ]);
        }
        $this->publishes([
            __DIR__.'/assets' => public_path('avart/forms'),
        ], 'public');

        $this->publishes([
            __DIR__.'/../database/seeds' => database_path('seeds'),
        ], 'seeds');
    }
}
