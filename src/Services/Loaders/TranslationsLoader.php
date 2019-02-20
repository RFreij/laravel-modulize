<?php

namespace LaravelModulize\Services\Loaders;

use Illuminate\Support\Collection;

class TranslationsLoader extends BaseFileLoader
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
            $this->repo->addTranslation($this->getFilesPath($module), $module);
        }
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

        return $this->repo->glob(
            $this->getFilesPath($module) . '/**/*.php'
        );
    }

    /**
     * Retrieve the path where the files to load should be at
     *
     * @param string $module
     * @return string
     */
    public function getFilesPath(string $module): string
    {
        return $this->repo->getModulePath($module) . "/resources/lang";
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
