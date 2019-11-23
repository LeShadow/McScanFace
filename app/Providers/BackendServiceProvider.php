<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BackendServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(
            'App\Repositories\UserRepositoryInterface',
            'App\Repositories\UserRepository'
        );

        $this->app->bind(
            'App\Repositories\ServerRepositoryInterface',
            'App\Repositories\ServerRepository'
        );

        $this->app->bind(
            'App\Repositories\ScanRepositoryInterface',
            'App\Repositories\ScanRepository'
        );

        $this->app->bind(
            'App\Repositories\ScanFilesRepositoryInterface',
            'App\Repositories\ScanFilesRepository'
        );

        $this->app->bind(
            'App\Repositories\PreferencesRepositoryInterface',
            'App\Repositories\PreferencesRepository'
        );
    }
}
