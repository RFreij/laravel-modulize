<?php

namespace LaravelModulize\Services;

use Illuminate\Support\Collection;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\DetectsApplicationNamespace;
use LaravelModulize\Contracts\ModulizerRepositoryInterface;

class ModulizerRepository implements ModulizerRepositoryInterface
{
    use DetectsApplicationNamespace;

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
        return $this->filesystem->exists(
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
}
