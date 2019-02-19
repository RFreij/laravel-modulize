<?php

namespace LaravelModulize\Services;

use Illuminate\Support\Collection;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\DetectsApplicationNamespace;
use LaravelModulize\Contracts\ModulizerRepositoryInterface;

class ModulizerRepository implements ModulizerRepositoryInterface
{
    use DetectsApplicationNamespace;

    /**
     * Instance of Filesystem
     *
     * @var \Illuminate\Contracts\Filesystem\Filesystem
     */
    protected $filesystem;

    /**
     * Construct ModulizerRepository
     *
     * @param \Illuminate\Filesystem\Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function getBasePath(): string
    {
        return config('modulizer.modules_path');
    }

    public function hasModules(): bool
    {
        return $this->filesystem->exists(
            $this->getBasePath()
        );
    }

    public function getModules(): Collection
    {
        return collect($this->filesystem->directories($this->getBasePath()))
            ->map(function ($directory) {
                return class_basename($directory);
            });
    }

    public function getModulePath(string $module): string
    {
        return $this->getBasePath() . "/{$module}";
    }

    public function getFiles(string $path): Collection
    {
        return collect($this->filesystem->files($path));
    }

    public function getRootNamespace(): string
    {
        return $this->getAppNamespace();
    }

    public function getModulesNamespace(): string
    {
        return config('modulizer.namespace');
    }

    public function getModuleNamespace(string $module): string
    {
        return $this->getRootNamespace() . $this->getModulesNamespace() . $module;
    }
}
