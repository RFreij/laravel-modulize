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

    /**
     * Collect all files preset at the given pattern
     *
     * @param string $path
     * @return \Illuminate\Support\Collection
     */
    public function glob(string $pattern): Collection;

    /**
     * Determine if a path or file exists
     *
     * @param string $path
     * @return boolean
     */
    public function filesExist(string $path): bool;

    /**
     * Add a translation path
     *
     * @param string $path
     * @param string $namespace
     * @return void
     */
    public function addTranslation(string $path, string $namespace);

    /**
     * Register factories.
     *
     * @param  string  $path
     * @return void
     */
    public function registerEloquentFactoriesFrom($path);

    /**
     * Add a migration to the array
     *
     * @param string $migrationPath
     * @return void
     */
    public function addMigration(string $migrationPath);

    /**
     * Create directory at given path
     *
     * @param string $path
     * @return void
     * @author Roy Freij <Roy@bsbip.com>
     * @date 2019-03-04
     */
    public function createDirectory(string $path): void;

    /**
     * Retrieve the database folder path of given module
     *
     * @param string $module
     * @return string
     * @author Roy Freij <Roy@bsbip.com>
     * @date 2019-03-04
     */
    public function databasePath(string $module): string;


    public function exceptionPath(string $module): string;

    public function modelPath(string $module): string;

    public function controllerPath(string $module): string;
}
