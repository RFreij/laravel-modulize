<?php

namespace LaravelModulize\Contracts;

use Illuminate\Support\Collection;

interface LoadsFiles
{
    /**
     * Retrieve the path where the files to load should be at
     *
     * @param string $module
     * @return string
     */
    public function getFilesPath(string $module): string;

    /**
     * Retrieve the namespace to be used when registering the files
     *
     * @param string $module
     * @return string
     */
    public function getNamespace(string $module): string;
}
