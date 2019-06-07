<?php

namespace LaravelModulize\Providers;

use Illuminate\Support\Collection;
use Illuminate\Filesystem\Filesystem;
use LaravelModulize\Services\Modulizer;
use LaravelModulize\Services\ModulizerRepository;
use LaravelModulize\Console\Commands\CreateModuleCommand;
use LaravelModulize\Console\Commands\GenerateModelCommand;
use LaravelModulize\Contracts\ModulizerRepositoryInterface;
use LaravelModulize\Console\Commands\GenerateFactoryCommand;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use LaravelModulize\Console\Commands\GenerateExceptionCommand;
use LaravelModulize\Console\Commands\GenerateControllerCommand;

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

        $this->loadCommands();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ModulizerRepository::class, function ($app) {
            return new ModulizerRepository(new Filesystem(), $app);
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

    /**
     * Load translation files
     *
     * @param Collection $translations
     * @return void
     * @author Roy Freij <Roy@bsbip.com>
     * @version 2019-03-04
     */
    protected function loadTranslations(Collection $translations)
    {
        $translations->each(function ($translationsFile) {
            $this->loadTranslationsFrom(
                $translationsFile->path,
                $translationsFile->namespace
            );
        });
    }

    protected function loadCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateModuleCommand::class,
                GenerateFactoryCommand::class,
                GenerateExceptionCommand::class,
                GenerateModelCommand::class,
                GenerateControllerCommand::class,
            ]);
        }
    }
}
