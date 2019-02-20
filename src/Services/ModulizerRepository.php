<?php

namespace LaravelModulize\Services;

use Illuminate\Console\DetectsApplicationNamespace;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use LaravelModulize\Contracts\ModulizerRepositoryInterface;

class ModulizerRepository implements ModulizerRepositoryInterface
{
    use DetectsApplicationNamespace;

    public $migrations = [];

    public $translations = [];

    /**
     * Instance of Filesystem
     *
     * @var \Illuminate\Contracts\Filesystem\Filesystem
     */
    protected $filesystem;

    /**
     * Construct ModulizerRepository
     *
     * @param \Illuminate\Filesystem\Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * Get the configurable base path to the folder the modules will be in.
     *
     * @return string
     */
    public function getBasePath(): string
    {
        return config('modulizer.modules_path');
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

    public function addTranslation(string $path, string $namespace)
    {
        $this->translations[] = (object) [
            'path' => $path,
            'namespace' => $namespace,
        ];
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
}
