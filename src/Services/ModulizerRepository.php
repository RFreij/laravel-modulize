<?php

namespace LaravelModulize\Services;

use Illuminate\Console\DetectsApplicationNamespace;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use LaravelModulize\Contracts\ModulizerRepositoryInterface;

class ModulizerRepository implements ModulizerRepositoryInterface
{
    use DetectsApplicationNamespace;

    public $migrations = [];

    public $translations = [];

    /**
     * Instance of Filesystem
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $filesystem;

    /**
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * Construct ModulizerRepository
     *
     * @param \Illuminate\Filesystem\Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem, Application $app)
    {
        $this->app = $app;
        $this->filesystem = $filesystem;
    }

    /**
     * Get the configurable base path to the folder the modules will be in.
     *
     * @return string
     */
    public function getBasePath(): string
    {
        return app_path(config('modulizer.modules_path'));
    }

    /**
     * Determine if there are modules available
     *
     * @return boolean
     */
    public function hasModules(): bool
    {
        return $this->filesExist(
            $this->getBasePath()
        );
    }

    /**
     * Collect the available modules
     *
     * @return \Illuminate\Support\Collection
     */
    public function getModules(): Collection
    {
        return collect($this->filesystem->directories($this->getBasePath()))
            ->map(function ($directory) {
                return class_basename($directory);
            });
    }

    /**
     * Retrieve the path for a single module
     *
     * @param string $module
     * @return string
     */
    public function getModulePath(string $module): string
    {
        return $this->getBasePath() . "/{$module}";
    }

    /**
     * Collect all files preset at the given path
     *
     * @param string $path
     * @return \Illuminate\Support\Collection
     */
    public function getFiles(string $path): Collection
    {
        return collect($this->filesystem->files($path));
    }

    /**
     * Collect all files preset at the given pattern
     *
     * @param string $path
     * @return \Illuminate\Support\Collection
     */
    public function glob(string $pattern): Collection
    {
        return collect($this->filesystem->glob($pattern));
    }

    /**
     * Determine if a path or file exists
     *
     * @param string $path
     * @return boolean
     */
    public function filesExist(string $path): bool
    {
        return $this->filesystem->exists(
            $path
        );
    }

    /**
     * Get the app's root namespace
     *
     * @return string
     */
    public function getRootNamespace(): string
    {
        return $this->getAppNamespace();
    }

    /**
     * Get the namespace the modules should recieve
     * This namespace will be a child of the root namespace
     *
     * @return string
     */
    public function getModulesNamespace(): string
    {
        return config('modulizer.namespace');
    }

    /**
     * Retrieve the namespace of a single module
     *
     * @param string $module
     * @return string
     */
    public function getModuleNamespace(string $module): string
    {
        return $this->getRootNamespace() . $this->getModulesNamespace() . $module;
    }

    /**
     * Add a translation path
     *
     * @param string $path
     * @param string $namespace
     * @return void
     */
    public function addTranslation(string $path, string $namespace)
    {
        $this->translations[] = (object) [
            'path' => $path,
            'namespace' => $namespace,
        ];
    }

    /**
     * Add a migration to the array
     *
     * @param string $migrationPath
     * @return void
     */
    public function addMigration(string $migrationPath)
    {
        $this->migrations[] = $migrationPath;
    }

    /**
     * Register factories.
     *
     * @param  string  $path
     * @return void
     */
    public function registerEloquentFactoriesFrom($path)
    {
        $this->app->make(EloquentFactory::class)->load($path);
    }

    /**
     * Create directory at given path
     *
     * @param string $path
     * @return void
     * @author Roy Freij <Roy@bsbip.com>
     * @version 2019-03-04
     */
    public function createDirectory(string $path): void
    {
        if (!$this->filesExist($path)) {
            $this->filesystem->makeDirectory($path, 0755, true);
        }
    }

    /**
     * Retrieve the database folder path of given module
     *
     * @param string $module
     * @return string
     * @author Roy Freij <Roy@bsbip.com>
     * @version 2019-03-04
     */
    public function databasePath(string $module): string
    {
        return $this->getModulePath($module) . '/database';
    }

    public function exceptionPath(string $module): string
    {
        return $this->getModulePath($module) . '/Exceptions';
    }

    public function modelPath(string $module): string
    {
        return $this->getModulePath($module) . '/Models';
    }

    public function controllerPath(string $module): string
    {
        return $this->getModulePath($module) . '/Http/Controllers';
    }
}
