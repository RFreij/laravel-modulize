<?php

namespace LaravelModulize\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\GeneratorCommand;
use LaravelModulize\Contracts\ModulizerRepositoryInterface;

abstract class BaseGeneratorCommand extends GeneratorCommand
{
    /**
     * Instance of the repository
     *
     * @var \LaravelModulize\Contracts\ModulizerRepositoryInterface
     */
    protected $repository;

    protected $module;
    protected $modulePath;

    /**
     * Create a new command instance.
     *
     * @param \LaravelModulize\Contracts\ModulizerRepositoryInterface $repository
     * @return void
     */
    public function __construct(Filesystem $files, ModulizerRepositoryInterface $repository)
    {
        parent::__construct($files);

        $this->repository = $repository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->module = $this->argument('module');
        $this->modulePath = $this->repository->getModulePath($this->module);

        if (!$this->repository->filesExist($this->modulePath)) {
            $this->call('modulize:make:module', [
                'module' => $this->module,
            ]);
        }

        parent::handle();
    }

    protected function getClassName($name)
    {
        return Str::contains($name, '/')
            ? array_reverse(explode('/', $name, 2))[0]
            : $name;
    }

    protected function getClassNamespace($name)
    {
        return Str::contains($name, '/')
            ? $this->convertPathToNamespace($name)
            : '';
    }

    protected function convertPathToNamespace($name)
    {
        return Str::start(str_replace('/', '', $this->getPathBeforeClassName($name)), '\\');
    }

    protected function getPathBeforeClassName($name)
    {
        return Str::before($name, $this->getClassName($name));
    }
}
