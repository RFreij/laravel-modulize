<?php

namespace LaravelModulize\Services\Loaders;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Collection;
use LaravelModulize\Contracts\ModulizerRepositoryInterface;

abstract class BaseFileLoader
{
    /**
     * Instance of Application
     *
     * @var \Illuminate\Contracts\Foundation\Application $app
     */
    protected $app;

    /**
     * Instance of the repository
     *
     * @var \LaravelModulize\Contracts\ModulizerRepositoryInterface
     */
    protected $repo;

    /**
     * Construct the RoutesLoader
     *
     * @param \LaravelModulize\Contracts\ModulizerRepositoryInterface $repository
     * @param \Illuminate\Contracts\Foundation\Application $app
     */
    public function __construct(ModulizerRepositoryInterface $repository, Application $app)
    {
        $this->app = $app;
        $this->repo = $repository;
    }

    /**
     * Go through each of the module and load the necesary files
     *
     * @return void
     */
    public function bootstrap(): void
    {
        $this->repo->getModules()->each(function ($module) {
            $this->loadFiles($module);
        });
    }

    /**
     * Retrieve the collection of files found for the given module
     *
     * @param string $module
     * @return \Illuminate\Support\Collection
     */
    public function getFilesToLoad(string $module): Collection
    {
        if (!$this->repo->filesExist($this->getFilesPath($module))) {
            return new Collection();
        }

        return $this->repo->getFiles(
            $this->getFilesPath($module)
        );
    }

    /**
     * Load the files to load and register them
     *
     * @param string $module
     * @return void
     */
    abstract public function loadFiles(string $module): void;

    /**
     * Retrieve the path where the files to load should be at
     *
     * @param string $module
     * @return string
     */
    abstract public function getFilesPath(string $module): string;

    /**
     * Retrieve the namespace to be used when registering the files
     *
     * @param string $module
     * @return string
     */
    abstract public function getNamespace(string $module): string;
}
