<?php

namespace LaravelModulize\Console\Commands;

use LaravelModulize\Contracts\ModulizerRepositoryInterface;
use Symfony\Component\Console\Input\InputOption;

class GenerateFactoryCommand extends BaseGeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'modulize:make:factory {module} {name} {model?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to generate a model factory';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return __DIR__ . '/stubs/Factory.stub';
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
        return $this->repository->databasePath($this->module) . "/factories/{$name}.php";
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $model = $this->argument('model') ?? 'Model';

        return str_replace(
            'DummyModel', $model, parent::buildClass($name)
        );
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['model', 'm', InputOption::VALUE_OPTIONAL, 'The name of the model'],
        ];
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
