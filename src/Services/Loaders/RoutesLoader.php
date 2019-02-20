<?php

namespace LaravelModulize\Services\Loaders;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class RoutesLoader extends BaseFileLoader
{
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
                $this->parseNamespace($module, $routeFile->getBasename()),
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
     * Parse the namespace that will be used in the Router
     * This enables the user to create as many route files as needed
     * If the baseName does not contain 'Routes' the namespace will be at the base Controller
     *
     * @param string $module
     * @param string $baseName
     * @return string
     */
    private function parseNamespace(string $module, string $baseName): string
    {
        $namespace = Str::contains($baseName, 'Routes')
        ? Str::start(Str::studly(Str::before($baseName, 'Routes')), '\\')
        : '';

        return $this->getNamespace($module) . $namespace;
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
