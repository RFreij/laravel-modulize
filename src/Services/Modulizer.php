<?php

namespace LaravelModulize\Services;

use Illuminate\Support\Collection;
use LaravelModulize\Services\RoutesLoader;
use Illuminate\Contracts\Foundation\Application;
use LaravelModulize\Contracts\ModulizerRepositoryInterface;

class Modulizer
{
    /**
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * Repository
     *
     * @var \LaravelModulize\Contracts\ModulizerRepositoryInterface
     */
    public $repository;

    /**
     * Register the file loaders to be bootstrapped
     *
     * @var array
     */
    protected $fileLoaders = [
        RoutesLoader::class
    ];

    /**
     * Modulizer constructor
     *
     * @param \LaravelModulize\Contracts\ModulizerRepositoryInterface $repository
     * @param \Illuminate\Contracts\Foundation\Application $app
     */
    public function __construct(ModulizerRepositoryInterface $repository, Application $app)
    {
        $this->app = $app;
        $this->repository = $repository;
    }

    /**
     * Bootstrap the file loaders for route, migration and translation files
     *
     * @return void
     */
    public function bootstrapFileLoaders()
    {
        if ($this->repository->hasModules()) {
            $this->getFileLoaders()->each(function ($fileLoader) {
                $this->call($fileLoader)->bootstrap();
            });
        }
    }

    /**
     * Create a new instance of the given class through the service container
     *
     * @param string $class
     * @return mixed
     */
    private function call(string $class)
    {
        return $this->app->make($class);
    }

    /**
     * Collect the fileLoaders for that should be bootstrapped
     *
     * @return \Illuminate\Support\Collection
     */
    private function getFileLoaders(): Collection
    {
        return collect($this->fileLoaders);
    }
}
