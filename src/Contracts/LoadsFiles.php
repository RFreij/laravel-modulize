<?php

namespace LaravelModulize\Contracts;

use Illuminate\Support\Collection;

interface LoadsFiles
{
    /**
     * Go through each of the module and load the necesary files
     *
     * @return void
     */
    public function bootstrap(): void;
    /**
     * Retrieve the path where the files to load should be at
     *
     * @param string $module
     * @return string
     */
    public function getFilesPath(string $module): string;

    /**
     * Retrieve the collection of files found for the given module
     *
     * @param string $module
     * @return \Illuminate\Support\Collection
     */
    public function getFilesToLoad(string $module): Collection;

    /**
     * Retrieve the namespace to be used when registering the files
     *
     * @param string $module
     * @return string
     */
    public function getNamespace(string $module): string;

    /**
     * Load the files to load and register them
     *
     * @param string $module
     * @return void
     */
    public function loadFiles(string $module): void;
}
