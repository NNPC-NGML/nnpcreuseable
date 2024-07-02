<?php

namespace Skillz\Nnpcreusable\Providers;

use Skillz\Nnpcreusable\Console\Commands\NnpcreusableDomainComponents;
use Illuminate\Support\ServiceProvider;






class NnpcreusableProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // $this->mergeConfigFrom(
        //     __DIR__ . '/../config/nnpcreusable.php',
        //     'nnpcreusable'
        // );
        $this->commands([
            NnpcreusableDomainComponents::class,
        ]);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //$this->loadRoutesFrom(__DIR__ . '/../routes/api.php');

        $this->publishes([
            __DIR__ . '/../config/nnpcreusable.php' => config_path('nnpcreusable.php'),
        ], 'config');
        // $this->publishesMigrations([
        //     __DIR__ . '/../database/migrations' => database_path('migrations'),
        // ]);
        // $this->publishes([
        //     __DIR__ . '/../Jobs/User/UserCreated.php' => app_path('Jobs/User/UserCreated.php'),
        // ], 'jobs');
        // \App::bindMethod(UserCreated::class . '@handle', fn ($job) => $job->handle());

        // $this->publishes([
        //     __DIR__ . '/../Jobs/User/UserDeleted.php' => app_path('Jobs/User/UserDeleted.php'),
        // ], 'users');
        // \App::bindMethod(UserDeleted::class . '@handle', fn ($job) => $job->handle());
        //\App::bindMethod(UnitCreated::class . '@handle', fn ($job) => $job->handle());


        // \App::bindMethod(UnitUpdated::class . '@handle', fn ($job) => $job->handle());
        // \App::bindMethod(UnitDeleted::class . '@handle', fn ($job) => $job->handle());
        // \App::bindMethod(DepartmentCreated::class . '@handle', fn ($job) => $job->handle());
        // \App::bindMethod(DepartmentUpdated::class . '@handle', fn ($job) => $job->handle());
        // \App::bindMethod(DesignationUpdated::class . '@handle', fn ($job) => $job->handle());
        // \App::bindMethod(DesignationCreated::class . '@handle', fn ($job) => $job->handle());
        // \App::bindMethod(DesignationDeleted::class . '@handle', fn ($job) => $job->handle());
        //$this->loadViewsFrom(__DIR__ . '/../views', 'inspire');
    }
}
