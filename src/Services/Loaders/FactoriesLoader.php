<?php

namespace LaravelModulize\Services\Loaders;

class FactoriesLoader extends BaseFileLoader
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
            $this->repo->registerEloquentFactoriesFrom($this->getFilesPath($module));
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
