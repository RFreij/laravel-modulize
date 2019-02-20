<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Collection;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Facades\LaravelModulize\Services\ModulizerRepository;
use Facades\LaravelModulize\Services\Modulizer;
use Facades\LaravelModulize\Services\Loader\RoutesLoader;

class ModulizerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testIfItCallsBootstrapFileLoaders()
    {
        Modulizer::shouldReceive('bootstrapFileLoaders')
            ->once()
            ->andReturn();

        $this->assertEquals(Modulizer::bootstrapFileLoaders(), null);
    }

    public function testIfItCallsCall()
    {
        Modulizer::shouldReceive('call')
            ->once()
            ->with(RoutesLoader::class)
            ->andReturn(new RoutesLoader);

        $this->assertEquals(Modulizer::call(RoutesLoader::class), new RoutesLoader);
    }

    public function testIfItCallsGetFileLoaders()
    {
        Modulizer::shouldReceive('getFileLoaders')
            ->once()
            ->andReturn(new Collection);

        $this->assertEquals(Modulizer::getFileLoaders(), new Collection);
    }

    public function testIfRepoGetsRootNamespace()
    {
        ModulizerRepository::shouldReceive('getRootNamespace')
            ->once()
            ->andReturn('App\\');

        $this->assertEquals(ModulizerRepository::getRootNamespace(), 'App\\');
    }
}
