<?php

namespace LaravelModulize\Console\Commands;

use Illuminate\Support\Str;
use LaravelModulize\Support\Entity;

class GenerateModelCommand extends BaseGeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'modulize:make:model {module} {name} {--c|controller} {--m|migration}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to generate a Model inside a module';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        parent::handle();

        if ($this->option('controller')) {
            $this->call('modulize:make:controller', [
                'module' => $this->module,
                'name' => Entity::getClassName($this->getNameInput()) . 'Controller',
                '--model' => $this->getNameInput(),
            ]);
        }

        if ($this->option('migration')) {
            $tableName = Str::plural(Str::snake(Entity::getClassName($this->getNameInput())));
            $this->call('make:migration', [
                'name' => "create_{$tableName}_table",
                '--create' => $tableName
            ]);
        }
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return __DIR__ . '/stubs/Model.stub';
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name): string
    {
        return $this->repository->modelPath($this->module) . '/' . $this->getNameInput() . '.php';
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
            'DummyModuleNamespace',
            'DummyModelNamespace',
        ];

        $replacements = [
            Entity::getClassName($this->getNameInput()),
            $this->repository->getModuleNamespace($this->module),
            Entity::convertPathToNamespace($this->getNameInput()),
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
