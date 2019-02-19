<?php

namespace LaravelModulize\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use LaravelModulize\Contracts\LoadsFiles;
use Illuminate\Contracts\Foundation\Application;
use LaravelModulize\Contracts\ModulizerRepositoryInterface;

class RoutesLoader  implements LoadsFiles
{
    protected $app;
    protected $repo;

    public function __construct(ModulizerRepositoryInterface $repository, Application $app)
    {
        $this->app = $app;
        $this->repo = $repository;
    }

    public function bootstrap(): void
    {
        $this->repo->getModules()->each(function ($module) {
            $this->loadFiles($module);
        });
    }

    public function loadFiles($module): void
    {
        $this->getFilesToLoad($module)->each(function ($routeFile) use ($module) {
            $this->registerRoute(
                $this->getNamespace($module),
                $routeFile->getRealPath()
            );
        });
    }

    public function getFilesPath(string $module): string
    {
        return $this->repo->getModulePath($module) . "/Http/Routes";
    }

    public function getFilesToLoad(string $module): Collection
    {
        return $this->repo->getFiles(
            $this->getFilesPath($module)
        );
    }

    public function getNamespace(string $module): string
    {
        return $this->repo
            ->getModuleNamespace($module) . '\\Http\\Controllers';
    }

    private function registerRoute(string $namespace, string $realPath)
    {
        if (!$this->app->routesAreCached()) {
            Route::middleware('api')
                ->namespace($namespace)
                ->group($realPath);
        }
    }
}
