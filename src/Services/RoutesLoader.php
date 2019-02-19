<?php

namespace LaravelModulize\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use LaravelModulize\Contracts\LoadsFiles;
use Illuminate\Contracts\Foundation\Application;
use LaravelModulize\Contracts\ModulizerRepositoryInterface;

class RoutesLoader  implements LoadsFiles
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
     * Load the files to load and register them
     *
     * @param string $module
     * @return void
     */
    public function loadFiles(string $module): void
    {
        $this->getFilesToLoad($module)->each(function ($routeFile) use ($module) {
            $this->registerRoute(
                $this->getNamespace($module),
                $routeFile->getRealPath()
            );
        });
    }

    /**
     * Retrieve the path where the files to load should be at
     *
     * @param string $module
     * @return string
     */
    public function getFilesPath(string $module): string
    {
        return $this->repo->getModulePath($module) . "/Http/Routes";
    }

    /**
     * Retrieve the collection of files found for the given module
     *
     * @param string $module
     * @return \Illuminate\Support\Collection
     */
    public function getFilesToLoad(string $module): Collection
    {
        return $this->repo->getFiles(
            $this->getFilesPath($module)
        );
    }

    /**
     * Retrieve the namespace to be used when registering the files
     *
     * @param string $module
     * @return string
     */
    public function getNamespace(string $module): string
    {
        return $this->repo
            ->getModuleNamespace($module) . '\\Http\\Controllers';
    }

    /**
     * First we check if the routes have been cached, if not
     * Load the routes while registering the namespace.
     *
     * @param string $namespace
     * @param string $realPath
     * @return void
     */
    private function registerRoute(string $namespace, string $realPath)
    {
        if (!$this->app->routesAreCached()) {
            Route::middleware('api')
                ->namespace($namespace)
                ->group($realPath);
        }
    }
}
