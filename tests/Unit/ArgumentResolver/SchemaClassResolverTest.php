<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Tests\Unit\ArgumentResolver;

use PHPUnit\Framework\TestCase;
use Ptyhard\JsonSchemaBundle\ArgumentResolver\SchemaClassResolver;
use Ptyhard\JsonSchemaBundle\SchemaObject\CheckerInterface;
use Ptyhard\JsonSchemaBundle\SchemaObject\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class SchemaClassResolverTest extends TestCase
{
    private $factory;

    private $checker;

    protected function setUp(): void
    {
        $this->factory = $this->prophesize(FactoryInterface::class);
        $this->checker = $this->prophesize(CheckerInterface::class);
    }

    public function testSupports(): void
    {
        $type = 'schema';

        $request = $this->prophesize(Request::class);
        $argument = $this->prophesize(ArgumentMetadata::class);

        $argument->getType()
            ->willReturn($type);

        $this->checker->isSchemaClass($type)
            ->willReturn(true);

        $schemaClassResolver = $this->createSchemaClassResolver();
        $schemaClassResolver->supports($request->reveal(), $argument->reveal());

        $this->checker->isSchemaClass($type)
            ->shouldHaveBeenCalled();
    }

    public function testSuppprtedThrowReflectionException(): void
    {
        $type = 'schema';

        $request = $this->prophesize(Request::class);
        $argument = $this->prophesize(ArgumentMetadata::class);

        $argument->getType()
            ->willReturn($type);

        $this->checker->isSchemaClass($type)
            ->willThrow(new \ReflectionException());

        $schemaClassResolver = $this->createSchemaClassResolver();
        $result = $schemaClassResolver->supports($request->reveal(), $argument->reveal());

        $this->checker->isSchemaClass($type)
            ->shouldHaveBeenCalled();

        $this->assertFalse($result);
    }

    private function createSchemaClassResolver(): SchemaClassResolver
    {
        return new SchemaClassResolver($this->factory->reveal(), $this->checker->reveal());
    }
}
