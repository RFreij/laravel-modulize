<?php

namespace Tests\Unit;

use Mockery;
use Tests\TestCase;
use LaravelModulize\Support\Entity;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EntityTest extends TestCase
{
    protected $entity;

    public function setUp()
    {
        parent::setUp();

        $this->entity = Mockery::mock(Entity::class);
    }

    public function testGetClassNameShouldReturnClassNameWithFullPath()
    {
        $this->entity->shouldReceive('getClassName')
            ->once()
            ->with('Frontend/FrontendController')
            ->andReturn('FrontendController')
            ->getMock();

        $this->assertEquals(
            $this->entity->getClassName('Frontend/FrontendController'),
            Entity::getClassName('Frontend/FrontendController')
        );
    }

    public function testGetClassNameShouldReturnClassNameWithOnlyName()
    {
        $this->entity->shouldReceive('getClassName')
            ->once()
            ->with('FrontendController')
            ->andReturn('FrontendController')
            ->getMock();

        $this->assertEquals(
            $this->entity->getClassName('FrontendController'),
            Entity::getClassName('FrontendController')
        );
    }

    public function testGetClassNamespaceShouldReturnFullNamespace()
    {
        $this->entity->shouldReceive('getClassNamespace')
            ->once()
            ->with('Frontend/FrontendController')
            ->andReturn('\Frontend')
            ->getMock();

        $this->assertEquals(
            $this->entity->getClassNamespace('Frontend/FrontendController'),
            Entity::getClassNamespace('Frontend/FrontendController')
        );
    }

    public function testgetPathBeforeClassNameShouldReturnParentFolder()
    {
        $this->entity->shouldReceive('getPathBeforeClassName')
            ->once()
            ->with('Frontend/FrontendController')
            ->andReturn('Frontend/')
            ->getMock();

        $this->assertEquals(
            $this->entity->getPathBeforeClassName('Frontend/FrontendController'),
            Entity::getPathBeforeClassName('Frontend/FrontendController')
        );
    }
}
