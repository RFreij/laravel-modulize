<?php

namespace Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

abstract class TestCase extends BaseTestCase
{
    use MockeryPHPUnitIntegration;

    protected function getPackageProviders($app)
    {
        return ['LaravelModulize\\Providers\\ModulizeServiceProvider'];
    }
}
