<?php

namespace LaravelModulize\Contracts;

use Illuminate\Support\Collection;

interface LoadsFiles
{
    public function bootstrap(): void;

    public function getFilesPath(string $module): string;

    public function getFilesToLoad(string $module): Collection;

    public function getNamespace(string $module): string;

    public function loadFiles(string $module): void;
}
