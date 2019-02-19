<?php

namespace LaravelModulize\Providers;

use Illuminate\Filesystem\Filesystem;
use LaravelModulize\Services\Modulizer;
use LaravelModulize\Services\ModulizerRepository;
use LaravelModulize\Contracts\ModulizerRepositoryInterface;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 * Service provider
 */
class ModulizeServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/../../routes.php');
        // $this->loadViewsFrom(__DIR__.'/../views', 'packagename');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ModulizerRepository::class, function ($app) {
            return new ModulizerRepository(new Filesystem());
        });

        $this->app->bind(
            ModulizerRepositoryInterface::class,
            ModulizerRepository::class
        );

        $this->app->singleton('modulizer', function ($app) {
            return $app->make(Modulizer::class);
        });

        $this->mergeConfigFrom(
            $this->getDefaultConfigFilePath('modulizer'), 'modulizer'
        );

        $this->app->get('modulizer')->bootstrapLoaders();
    }


    /**
     * Get default configuration file path
     *
     * @return string
     */
    public function getDefaultConfigFilePath($configName)
    {
        return realpath(__DIR__ . "/../config/{$configName}.php");
    }
}
