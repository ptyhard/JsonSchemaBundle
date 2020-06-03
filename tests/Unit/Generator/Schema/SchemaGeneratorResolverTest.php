<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Tests\Unit\Generator\Schema;

use PHPUnit\Framework\TestCase;
use Ptyhard\JsonSchemaBundle\Annotations\SchemaClass;
use Ptyhard\JsonSchemaBundle\Exception\SchemaGeneratorException;
use Ptyhard\JsonSchemaBundle\Generator\Schema\Generators\ObjectSchemaGenerator;
use Ptyhard\JsonSchemaBundle\Generator\Schema\SchemaGeneratorResolver;

class SchemaGeneratorResolverTest extends TestCase
{
    public function testResolve(): void
    {
        $objectSchemaGenerator = new ObjectSchemaGenerator();
        $generator = new SchemaGeneratorResolver([$objectSchemaGenerator]);
        $schemaClass = new SchemaClass([]);
        $actual = $generator->resolve($schemaClass);

        $this->assertSame($objectSchemaGenerator, $actual);
    }

    public function testResolveError(): void
    {
        $this->expectException(SchemaGeneratorException::class);
        $generator = new SchemaGeneratorResolver([]);
        $schemaClass = new SchemaClass([]);
        $generator->resolve($schemaClass);
    }
}
