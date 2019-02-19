<?php

namespace LaravelModulize\Contracts;

use Illuminate\Support\Collection;

interface ModulizerRepositoryInterface
{
    public function getBasePath(): string;

    public function hasModules(): bool;

    public function getModules(): Collection;

    public function getModulePath(string $module): string;

    public function getFiles(string $path): Collection;

    public function getRootNamespace(): string;

}
