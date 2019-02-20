<?php

namespace LaravelModulize\Services\Loaders;

use Illuminate\Support\Collection;
use LaravelModulize\Contracts\LoadsFiles;
use Illuminate\Contracts\Foundation\Application;
use LaravelModulize\Contracts\ModulizerRepositoryInterface;

class FactoriesLoader extends BaseFileLoader implements LoadsFiles
{
    /**
     * Load the files to load and register them
     *
     * @param string $module
     * @return void
     */
    public function loadFiles(string $module): void
    {
        if (!$this->getFilesToLoad($module)->isEmpty()) {
            $this->repo->registerEloquentFactoriesFrom($this->getFilesPath());
        }
    }

    /**
     * Retrieve the path where the files to load should be at
     *
     * @param string $module
     * @return string
     */
    public function getFilesPath(string $module): string
    {
        return $this->repo->getModulePath($module) . "/database/factories";
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
            ->getModuleNamespace($module);
    }

}
