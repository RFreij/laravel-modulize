<?php

namespace LaravelModulize\Providers;

use Illuminate\Support\Collection;
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
        $this->app->get('modulizer')->bootstrapFileLoaders();

        $this->loadMigrationsFrom($this->app->get(ModulizerRepository::class)->migrations);

        $this->loadTranslations(
            collect($this->app->get(ModulizerRepository::class)->translations)
        );

        $this->publishes([
            $this->getDefaultConfigFilePath('modulizer') => config_path('modulizer.php'),
        ], 'config');
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

    protected function loadTranslations(Collection $translations)
    {
        $translations->each(function ($translationsFile) {
            $this->loadTranslationsFrom(
                $translationsFile->path,
                $translationsFile->namespace
            );
        });
    }
}
