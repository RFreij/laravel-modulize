<?php

namespace LaravelModulize\Console\Commands;

use Illuminate\Support\Str;
use LaravelModulize\Support\Entity;

class GenerateControllerCommand extends BaseGeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'modulize:make:controller {module} {name} {--m|model=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a controller for the module';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        parent::handle();
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        if ($this->option('model')) {
            return __DIR__ . '/stubs/ModelController.stub';
        }

        return __DIR__ . '/stubs/Controller.stub';
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name): string
    {
        return $this->repository->controllerPath($this->module) . '/' . $this->getNameInput() . '.php';
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $dummies = [
            'DummyClass',
            'DummyModel',
            'DummyLowercasedModel',
            'DummyControllerNamespace',
            'DummyModuleNamespace',
            'ModelName',
        ];

        $modelName = Entity::getClassName($this->option('model'));

        $replacements = [
            Entity::getClassName($this->getNameInput()),
            str_replace('/', '\\', $this->option('model')),
            Str::lower($this->option('model')),
            Entity::getClassNamespace($this->getNameInput()),
            $this->repository->getModuleNamespace($this->module),
        ];

        return str_replace($dummies, $replacements, parent::buildClass($name));
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
