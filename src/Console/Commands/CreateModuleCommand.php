<?php

namespace LaravelModulize\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use LaravelModulize\Contracts\ModulizerRepositoryInterface;

class CreateModuleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'modulize:make:module {module}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sets up the default folder structure for the module.';

    /**
     * Instance of the repository
     *
     * @var \LaravelModulize\Contracts\ModulizerRepositoryInterface
     */
    protected $repository;

    /**
     * Create a new command instance.
     *
     * @param \LaravelModulize\Contracts\ModulizerRepositoryInterface $repository
     * @return void
     */
    public function __construct(ModulizerRepositoryInterface $repository)
    {
        parent::__construct();

        $this->repository = $repository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $module = $this->argument('module');

        $this->generateDirectives($module);
    }

    protected function generateDirectives(string $module)
    {
        $folders = config('modulizer.default_folders');
        $modulePath = $this->repository->getModulePath($module);

        foreach ($folders as $folder) {
            $this->makeFileTree($modulePath, $folder);
        }
    }

    protected function makeFileTree($path, $folders)
    {
        if(is_array($folders)) {
            if (is_string(key($folders))) {
                $folderName = key($folders);
                $path = "{$path}/{$folderName}";
            }
            foreach ($folders as $subFolders) {
                $this->makeFileTree($path, $subFolders);
            }
        } else {
            $this->repository->createDirectory("{$path}/{$folders}");
        }
    }
}
