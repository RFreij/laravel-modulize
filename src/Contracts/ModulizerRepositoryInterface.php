<?php

namespace LaravelModulize\Contracts;

use Illuminate\Support\Collection;

interface ModulizerRepositoryInterface
{
    /**
     * Get the configurable base path to the folder the modules will be in.
     *
     * @return string
     */
    public function getBasePath(): string;

    /**
     * Determine if there are modules available
     *
     * @return boolean
     */
    public function hasModules(): bool;

    /**
     * Collect the available modules
     *
     * @return \Illuminate\Support\Collection
     */
    public function getModules(): Collection;

    /**
     * Retrieve the path for a single module
     *
     * @param string $module
     * @return string
     */
    public function getModulePath(string $module): string;

    /**
     * Collect all files available at the given path
     *
     * @param string $path
     * @return \Illuminate\Support\Collection
     */
    public function getFiles(string $path): Collection;
    /**
     * Get the app's root namespace
     *
     * @return string
     */
    public function getRootNamespace(): string;

    /**
     * Get the namespace the modules should recieve
     * This namespace will be a child of the root namespace
     *
     * @return string
     */
    public function getModulesNamespace(): string;

    /**
     * Retrieve the namespace of a single module
     *
     * @param string $module
     * @return string
     */
    public function getModuleNamespace(string $module): string;

}
