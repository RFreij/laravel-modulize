<?php

namespace LaravelModulize\Console\Commands;

class GenerateExceptionCommand extends BaseGeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'modulize:make:exception {module} {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a exception only thrown by given module';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return __DIR__ . '/stubs/Exception.stub';
    }

        /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name): string
    {
        $name = str_replace(
            ['\\', '/'], '', $this->argument('name')
        );
        return $this->repository->exceptionPath($this->module) . "/{$name}.php";
    }

        /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $model = $this->argument('name');

        return str_replace(
            'DummyException', $model, parent::buildClass($name)
        );
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $this->repository->getModuleNamespace($this->module);
    }
}
