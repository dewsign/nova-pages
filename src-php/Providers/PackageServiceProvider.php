<?php

namespace Dewsign\NovaPages\Providers;

use Laravel\Nova\Nova;
use Illuminate\Routing\Router;
use Dewsign\NovaPages\Models\Page;
use Illuminate\Pagination\Paginator;
use Dewsign\NovaPages\Nova\Repeaters;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class PackageServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $this->publishConfigs();
        $this->bootViews();
        $this->bootAssets();
        $this->bootCommands();
        $this->publishDatabaseFiles();
        $this->registerWebRoutes();
        $this->registerMorphMaps();
        $this->configurePagination();
        $this->loadTranslations();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        Nova::resources([
            Repeaters::class,
        ]);

        $this->mergeConfigFrom(
            $this->getConfigsPath(),
            'NovaPages'
        );
    }

    /**
     * Publish configuration file.
     *
     * @return void
     */
    private function publishConfigs()
    {
        $this->publishes([
            $this->getConfigsPath() => config_path('NovaPages.php'),
        ], 'config');
    }

    /**
     * Get local package configuration path.
     *
     * @return string
     */
    private function getConfigsPath()
    {
        return __DIR__.'/../Config/NovaPages.php';
    }

    /**
     * Register the artisan packages' terminal commands
     *
     * @return void
     */
    private function bootCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                // MyCommand::class,
            ]);
        }
    }

    /**
     * Load custom views
     *
     * @return void
     */
    private function bootViews()
    {
        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'nova-pages');
        $this->publishes([
            __DIR__.'/../Resources/views' => resource_path('views/vendor/nova-pages'),
        ]);
    }

    /**
     * Define publishable assets
     *
     * @return void
     */
    private function bootAssets()
    {
        $this->publishes([
            __DIR__.'/../Resources/assets/js' => resource_path('assets/js/vendor/nova-pages'),
        ], 'js');
    }

    private function publishDatabaseFiles()
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/migrations');

        $this->app->make('Illuminate\Database\Eloquent\Factory')->load(
            __DIR__ . '/../Database/factories'
        );

        $this->publishes([
            __DIR__ . '/../Database/factories' => base_path('database/factories')
        ], 'factories');

        $this->publishes([
            __DIR__ . '/../Database/migrations' => base_path('database/migrations')
        ], 'migrations');

        $this->publishes([
            __DIR__ . '/../Database/seeds' => base_path('database/seeds')
        ], 'seeds');
    }

    /**
     * Load Web Routes into the application
     *
     * @return void
     */
    private function registerWebRoutes()
    {
        $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');
    }

    /**
     * Register the Mophmaps
     *
     * @return void
     */
    private function registerMorphmaps()
    {
        Relation::morphMap([
            'novapages.page' => Page::class,
        ]);
    }

    /**
     * Set te default pagination to not use bootstrap markup
     *
     * @return void
     */
    private function configurePagination()
    {
        Paginator::defaultView('pagination::default');
    }

    private function loadTranslations()
    {
        $this->loadJSONTranslationsFrom(__DIR__.'/../Resources/lang', 'novapages');
    }
}
