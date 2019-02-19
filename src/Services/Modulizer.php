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

    protected $fileLoaders = [
        RoutesLoader::class
    ];

    /**
     * Modulizer constructor
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     */
    public function __construct(ModulizerRepositoryInterface $repository, Application $app)
    {
        $this->app = $app;
        $this->repository = $repository;

        $this->bootstrapLoaders();
    }

    public function bootstrapLoaders()
    {
        dump($this->repository->hasModules());
        if ($this->repository->hasModules()) {
            $this->getFileLoaders()->each(function ($fileLoader) {
                $this->call($fileLoader)->bootstrap();
            });
        }
    }

    private function call(string $class)
    {
        return $this->app->make($class);
    }

    private function getFileLoaders(): Collection
    {
        return collect($this->fileLoaders);
    }
}
